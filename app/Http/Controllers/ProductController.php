<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Size;
use App\Models\Color;
use App\Models\CompanyLocation;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $company_id = auth()->user()->company_id;
        
        $query = Product::where('company_id', $company_id)
            ->with('category', 'brand')
            ->orderBy('id', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('sku', 'like', "%{$search}%")
                ->orWhere('barcode', 'like', "%{$search}%");
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->paginate(15);
        $categories = Category::where('company_id', $company_id)->orderBy('name')->get();
        $brands = Brand::where('company_id', $company_id)->orderBy('name')->get();
        $statuses = ['draft', 'published', 'out_of_stock', 'inactive'];

        return view('dashboard.products.index', compact('products', 'categories', 'brands', 'statuses'));
    }

    public function create()
    {
        $company_id = auth()->user()->company_id;
        $categories = Category::where('company_id', $company_id)->orderBy('name')->get();
        $brands = Brand::where('company_id', $company_id)->orderBy('name')->get();
        $sizes = Size::where('company_id', $company_id)->orderBy('name')->get();
        $colors = Color::where('company_id', $company_id)->orderBy('name')->get();
        $locations = CompanyLocation::where('company_id', $company_id)->orderBy('name')->get();
        $statuses = ['draft', 'published', 'out_of_stock', 'inactive'];

        return view('dashboard.products.create', compact('categories', 'brands', 'sizes', 'colors', 'locations', 'statuses'));
    }

    public function store(Request $request)
    {
        $company_id = auth()->user()->company_id;

        $validated = $request->validate([
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')->where('company_id', $company_id)],
            'brand_id' => ['nullable', 'integer', Rule::exists('brands', 'id')->where('company_id', $company_id)],
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'barcode' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'minimum_order_quantity' => 'nullable|integer|min:1',
            'unit' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric|min:0',
            'status' => ['required', Rule::in(['draft', 'published', 'out_of_stock', 'inactive'])],
            'featured' => 'nullable|boolean',
            'variants' => 'nullable|array',
            'product_images' => 'nullable|array',
            'product_videos' => 'nullable|array',
            'locations' => 'nullable|array',
        ]);

        // Auto-generate SKU if not provided
        if (empty($validated['sku'])) {
            $companyPrefix = strtoupper(substr(auth()->user()->company->name, 0, 3));
            $lastProduct = Product::where('company_id', $company_id)->latest('id')->first();
            $nextNumber = $lastProduct ? str_pad($lastProduct->id + 1, 5, '0', STR_PAD_LEFT) : '00001';
            $validated['sku'] = $companyPrefix . '-' . $nextNumber;
        }

        $validated['company_id'] = $company_id;
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['quantity'] = $validated['quantity'] ?? 0;
        $validated['minimum_order_quantity'] = $validated['minimum_order_quantity'] ?? 1;
        $validated['unit'] = $validated['unit'] ?? 'pcs';
        $validated['featured'] = $request->has('featured');

        $product = Product::create($validated);

        // Handle Product Variants
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                if (!empty($variantData['size']) || !empty($variantData['color'])) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size' => $variantData['size'] ?? null,
                        'color' => $variantData['color'] ?? null,
                        'sku' => $variantData['sku'] ?? null,
                        'barcode' => $variantData['barcode'] ?? null,
                        'quantity' => $variantData['quantity'] ?? 0,
                        'price' => $variantData['price'] ?? null,
                        'discount_price' => $variantData['discount_price'] ?? null,
                        'cost_price' => $variantData['cost_price'] ?? null,
                    ]);
                }
            }
        }

        // Handle Product Images
        if ($request->hasFile('new_product_images')) {
            foreach ($request->file('new_product_images') as $index => $imageFile) {
                $imagePath = $imageFile->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $imagePath,
                    'is_featured' => $index === 0, // First image is featured
                    'sort_order' => $index,
                ]);
            }
        }

        // Handle Product Videos
        if ($request->hasFile('product_videos')) {
            foreach ($request->file('product_videos') as $videoFile) {
                $videoPath = $videoFile->store('product_videos', 'public');
                ProductVideo::create([
                    'product_id' => $product->id,
                    'video' => $videoPath,
                ]);
            }
        }

        // Save locations
        if ($request->has('locations')) {
            foreach ($request->locations as $location_id => $data) {
                if (isset($data['selected']) && $data['selected'] == 1) {
                    $product->companyLocations()->attach($location_id, [
                        'quantity' => $data['quantity'] ?? 0,
                        'is_visible' => true,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        return redirect()->route('products.show', $product)
            ->with('success', __('products.product_created_successfully'));
    }

    public function show(Product $product)
    {
        $this->authorizeProduct($product);
        $product->load('category', 'brand', 'images', 'videos', 'variants', 'sizes', 'colors', 'companyLocations');

        return view('dashboard.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $this->authorizeProduct($product);
        $company_id = auth()->user()->company_id;
        $categories = Category::where('company_id', $company_id)->orderBy('name')->get();
        $brands = Brand::where('company_id', $company_id)->orderBy('name')->get();
        $sizes = Size::where('company_id', $company_id)->orderBy('name')->get();
        $colors = Color::where('company_id', $company_id)->orderBy('name')->get();
        $locations = CompanyLocation::where('company_id', $company_id)->orderBy('name')->get();
        $statuses = ['draft', 'published', 'out_of_stock', 'inactive'];

        $product->load('sizes', 'colors', 'companyLocations', 'images', 'videos', 'variants');

        return view('dashboard.products.edit', compact('product', 'categories', 'brands', 'sizes', 'colors', 'locations', 'statuses'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeProduct($product);
        $company_id = auth()->user()->company_id;

        $validated = $request->validate([
            'category_id' => ['sometimes', 'required', 'integer', Rule::exists('categories', 'id')->where('company_id', $company_id)],
            'brand_id' => ['nullable', 'integer', Rule::exists('brands', 'id')->where('company_id', $company_id)],
            'name' => 'sometimes|required|string|max:255',
            'slug' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product->id)],
            'sku' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($product->id)],
            'barcode' => 'nullable|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'minimum_order_quantity' => 'nullable|integer|min:1',
            'unit' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric|min:0',
            'status' => ['sometimes', 'required', Rule::in(['draft', 'published', 'out_of_stock', 'inactive'])],
            'featured' => 'nullable|boolean',
            'variants' => 'nullable|array',
            'existing_images' => 'nullable|array',
            'featured_image_id' => 'nullable|integer',
            'locations' => 'nullable|array',
        ]);

        $validated['featured'] = $request->has('featured');

        if (isset($validated['name']) && !isset($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $product->update($validated);

        // Handle Variants
        $product->variants()->delete();
        if ($request->has('variants')) {
            foreach ($request->variants as $variantData) {
                if (!empty($variantData['size']) || !empty($variantData['color'])) {
                    ProductVariant::create([
                        'product_id' => $product->id,
                        'size' => $variantData['size'] ?? null,
                        'color' => $variantData['color'] ?? null,
                        'sku' => $variantData['sku'] ?? null,
                        'barcode' => $variantData['barcode'] ?? null,
                        'quantity' => $variantData['quantity'] ?? 0,
                        'price' => $variantData['price'] ?? null,
                        'discount_price' => $variantData['discount_price'] ?? null,
                        'cost_price' => $variantData['cost_price'] ?? null,
                    ]);
                }
            }
        }

        // Handle Existing Images (sort order and featured)
        if ($request->has('existing_images')) {
            foreach ($request->existing_images as $imageData) {
                $productImage = ProductImage::find($imageData['id']);
                if ($productImage) {
                    $productImage->sort_order = $imageData['sort_order'] ?? 0;
                    $productImage->is_featured = ($imageData['id'] == $request->featured_image_id);
                    $productImage->save();
                }
            }
        }

        // Handle New Product Images
        if ($request->hasFile('new_product_images')) {
            $currentMaxSortOrder = $product->images()->max('sort_order') ?? 0;
            foreach ($request->file('new_product_images') as $index => $imageFile) {
                $imagePath = $imageFile->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_url' => $imagePath,
                    'is_featured' => false,
                    'sort_order' => $currentMaxSortOrder + $index + 1,
                ]);
            }
        }

        // Handle Product Videos
        if ($request->hasFile('product_videos')) {
            foreach ($request->file('product_videos') as $videoFile) {
                $videoPath = $videoFile->store('product_videos', 'public');
                ProductVideo::create([
                    'product_id' => $product->id,
                    'video' => $videoPath,
                ]);
            }
        }

        // Update locations
        $product->companyLocations()->detach();
        if ($request->has('locations')) {
            foreach ($request->locations as $location_id => $data) {
                if (isset($data['selected']) && $data['selected'] == 1) {
                    $product->companyLocations()->attach($location_id, [
                        'quantity' => $data['quantity'] ?? 0,
                        'is_visible' => true,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }

        return redirect()->route('products.show', $product)
            ->with('success', __('products.product_updated_successfully'));
    }

    public function destroy(Product $product)
    {
        $this->authorizeProduct($product);

        // Delete images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_url);
        }
        $product->images()->delete();

        // Delete videos
        foreach ($product->videos as $video) {
            Storage::disk('public')->delete($video->video);
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }
        }
        $product->videos()->delete();

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', __('products.product_deleted_successfully'));
    }

    public function deleteImage(Request $request, $imageId)
    {
        $image = ProductImage::findOrFail($imageId);
        $product = $image->product;
        
        $this->authorizeProduct($product);
        
        Storage::disk('public')->delete($image->image_url);
        $image->delete();
        
        return back()->with('success', 'Image deleted successfully');
    }

    public function deleteVideo(Request $request, $videoId)
    {
        $video = ProductVideo::findOrFail($videoId);
        $product = $video->product;
        
        $this->authorizeProduct($product);
        
        Storage::disk('public')->delete($video->video);
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }
        $video->delete();
        
        return back()->with('success', 'Video deleted successfully');
    }

    private function authorizeProduct(Product $product)
    {
        abort_if($product->company_id !== auth()->user()->company_id, 403);
    }
}
