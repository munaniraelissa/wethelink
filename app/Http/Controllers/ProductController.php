<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Company;
use App\Models\CompanyLocation;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVideo;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Spatie\Permission\Exceptions\PermissionDoesNotExist;
use Spatie\Permission\Models\Permission;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        abort_if(!$user?->can('product-list'), 403);

        $query = Product::with(['category', 'brand', 'images', 'company'])
            ->orderBy('id', 'desc');

        if (!$user->hasRole('Super Admin')) {
            $query->where('company_id', $user->company_id);
        }

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

        $products = $query->paginate(25)->withQueryString();
        $categories = Category::query()->orderBy('name')->get();
        $brands = Brand::query()->orderBy('name')->get();
        $statuses = ['draft', 'published', 'out_of_stock', 'inactive'];
        $i=0;

        return view('dashboard.products.index', compact('products', 'categories', 'brands', 'statuses','i'));
    }

    public function create()
    {
        abort_if(!auth()->user()?->can('product-create'), 403);

        $user = auth()->user();
        $company_id = $user->company_id;
        $categories = Category::query()->orderBy('name')->get();
        $brands = Brand::query()->orderBy('name')->get();
        $sizes = Size::query()->orderBy('name')->get();
        $colors = Color::query()->orderBy('name')->get();
        $locations = CompanyLocation::where('company_id', $company_id)->orderBy('name')->get();
        $statuses = ['draft', 'published', 'out_of_stock', 'inactive'];
        $canSelectCompany = $this->canSelectProductCompany($user);
        $companies = $canSelectCompany ? Company::query()->orderBy('name')->get() : collect();

        return view('dashboard.products.create', compact('categories', 'brands', 'sizes', 'colors', 'locations', 'statuses', 'canSelectCompany', 'companies'));
    }

    public function store(Request $request)
    {
        abort_if(!auth()->user()?->can('product-create'), 403);

        $user = auth()->user();
        $company_id = $user->company_id;

        $validated = $request->validate([
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'brand_id' => ['nullable', 'integer', Rule::exists('brands', 'id')],
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'sku' => 'nullable|string|max:255|unique:products,sku',
            'barcode' => 'required|string|max:255',
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
            'is_featured' => 'nullable|boolean',
            'variants' => 'nullable|array',
            'new_product_images' => 'nullable|array',
            'new_product_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'product_videos' => 'nullable|array',
            'product_videos.*' => 'file|mimes:mp4,mov,ogg,qt|max:102400',
            'locations' => 'nullable|array',
            'company_id' => ['nullable', 'integer', Rule::exists('companies', 'id')],
        ]);

        if ($this->userHasPermission($user, 'select_product_company') && $request->filled('company_id')) {
            $company_id = (int) $request->input('company_id');
        }

        // Auto-generate SKU if not provided
        if (empty($validated['sku'])) {
            $company = Company::find($company_id);
            $companyName = $company ? $company->name : auth()->user()->company?->name;
            $companyPrefix = strtoupper(substr($companyName ?? 'GEN', 0, 3));

            $existingSkus = Product::where('sku', 'like', $companyPrefix.'-%')
                ->pluck('sku');

            $usedNumbers = [];
            foreach ($existingSkus as $sku) {
                if (preg_match('/^'.preg_quote($companyPrefix, '/').'\-(\d{5})$/', $sku, $matches)) {
                    $usedNumbers[(int) $matches[1]] = true;
                }
            }

            $nextNumber = 1;
            while (isset($usedNumbers[$nextNumber])) {
                $nextNumber++;
            }

            $validated['sku'] = $companyPrefix.'-'.str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
        }

        $validated['company_id'] = $company_id;
        $validated['slug'] = $validated['slug'] ?? Str::slug($validated['name']);
        $validated['quantity'] = $validated['quantity'] ?? 0;
        $validated['minimum_order_quantity'] = $validated['minimum_order_quantity'] ?? 1;
        $validated['unit'] = $validated['unit'] ?? 'pcs';
        $validated['is_featured'] = $request->has('is_featured');

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
                $imagePath = \App\Support\ImageOptimizer::optimizePublic($imageFile->store('products', 'public'));
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image = $imagePath;
                $productImage->is_featured = $index === 0;
                $productImage->sort_order = $index;
                $productImage->save();
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

        // Location handling is intentionally ignored for now; products are scoped by company.

        return redirect()->route('products.show', $product)
            ->with('success', __('products.product_created_successfully'));
    }

    public function show(Product $product)
    {
        abort_if(!auth()->user()?->can('product-show'), 403);
        $this->authorizeProduct($product);
        $product->load('category', 'brand', 'images', 'videos', 'variants', 'sizes', 'colors', 'companyLocations');

        return view('dashboard.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        abort_if(!auth()->user()?->can('product-edit'), 403);
        $this->authorizeProduct($product);
        $user = auth()->user();
        $company_id = $user->company_id;
        $categories = Category::query()->orderBy('name')->get();
        $brands = Brand::query()->orderBy('name')->get();
        $sizes = Size::query()->orderBy('name')->get();
        $colors = Color::query()->orderBy('name')->get();
        $locations = CompanyLocation::where('company_id', $company_id)->orderBy('name')->get();
        $statuses = ['draft', 'published', 'out_of_stock', 'inactive'];
        $canSelectCompany = $this->canSelectProductCompany($user);
        $companies = $canSelectCompany ? Company::query()->orderBy('name')->get() : collect();

        $product->load('sizes', 'colors', 'companyLocations', 'images', 'videos', 'variants');

        return view('dashboard.products.edit', compact('product', 'categories', 'brands', 'sizes', 'colors', 'locations', 'statuses', 'canSelectCompany', 'companies'));
    }

    public function update(Request $request, Product $product)
    {
        abort_if(!auth()->user()?->can('product-edit'), 403);
        $this->authorizeProduct($product);
        $user = auth()->user();
        $company_id = $product->company_id; // keep current owner unless explicitly reassigned

        $validated = $request->validate([
            'category_id' => ['sometimes', 'required', 'integer', Rule::exists('categories', 'id')],
            'brand_id' => ['nullable', 'integer', Rule::exists('brands', 'id')],
            'name' => 'sometimes|required|string|max:255',
            'slug' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product->id)],
            'sku' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($product->id)],
            'barcode' => 'required|string|max:255',
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
            'is_featured' => 'nullable|boolean',
            'variants' => 'nullable|array',
            'existing_images' => 'nullable|array',
            'featured_image_id' => 'nullable|integer',
            'new_product_images' => 'nullable|array',
            'new_product_images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'product_videos' => 'nullable|array',
            'product_videos.*' => 'file|mimes:mp4,mov,ogg,qt|max:102400',
            'locations' => 'nullable|array',
            'company_id' => ['nullable', 'integer', Rule::exists('companies', 'id')],
        ]);

        if ($this->userHasPermission($user, 'select_product_company') && $request->filled('company_id')) {
            $company_id = (int) $request->input('company_id');
        }

        unset($validated['company_id']); // don't let mass assignment override the resolved value below
        $validated['company_id'] = $company_id;
        $validated['is_featured'] = $request->has('is_featured');

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

        // Handle selected image deletions
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $productImage = $product->images()->find($imageId);
                if ($productImage) {
                    Storage::disk('public')->delete($productImage->image);
                    $productImage->delete();
                }
            }
        }

        // Handle New Product Images
        if ($request->hasFile('new_product_images')) {
            $currentMaxSortOrder = $product->images()->max('sort_order') ?? 0;
            foreach ($request->file('new_product_images') as $index => $imageFile) {
                $imagePath = \App\Support\ImageOptimizer::optimizePublic($imageFile->store('products', 'public'));
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image = $imagePath;
                $productImage->is_featured = false;
                $productImage->sort_order = $currentMaxSortOrder + $index + 1;
                $productImage->save();
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

        // Handle selected video deletions
        if ($request->has('delete_videos')) {
            foreach ($request->delete_videos as $videoId) {
                $video = $product->videos()->find($videoId);
                if ($video) {
                    Storage::disk('public')->delete($video->video);
                    if ($video->thumbnail) {
                        Storage::disk('public')->delete($video->thumbnail);
                    }
                    $video->delete();
                }
            }
        }

        // Location handling is intentionally ignored for now; products are scoped by company.

        return redirect()->route('products.show', $product)
            ->with('success', __('products.product_updated_successfully'));
    }

    public function destroy(Product $product)
    {
        abort_if(!auth()->user()?->can('product-delete'), 403);
        $this->authorizeProduct($product);

        // Delete images
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
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
        abort_if(!auth()->user()?->can('product-edit'), 403);

        $image = ProductImage::findOrFail($imageId);
        $product = $image->product;

        $this->authorizeProduct($product);

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Image deleted successfully');
    }

    public function deleteVideo(Request $request, $videoId)
    {
        abort_if(!auth()->user()?->can('product-edit'), 403);

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
        $user = auth()->user();

        if ($this->userHasPermission($user, 'select_product_company')) {
            return;
        }

        abort_if($product->company_id !== $user->company_id, 403);
    }

    private function canSelectProductCompany($user): bool
    {
        return $this->userHasPermission($user, 'select_product_company');
    }

    private function userHasPermission($user, string $permissionName): bool
    {
        if (!$user) {
            return false;
        }

        try {
            $permission = Permission::findByName($permissionName, 'web');

            return $user->hasPermissionTo($permission);
        } catch (PermissionDoesNotExist $e) {
            Permission::findOrCreate($permissionName, 'web');

            return false;
        }
    }
}
