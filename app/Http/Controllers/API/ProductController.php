<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\ProductVideo;
use App\Models\ProductLocation;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    use ActionLogTrait;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('permission:product-list|product-create|product-edit|product-delete', ['only' => ['index','show']]);
        $this->middleware('permission:product-create', ['only' => ['store']]);
        $this->middleware('permission:product-edit', ['only' => ['update','uploadImages','uploadVideo','deleteImage','deleteVideo','setPrimaryImage']]);
        $this->middleware('permission:product-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->filled('company_id'), fn ($query) => $query->where('company_id', $request->company_id))
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('company_id'), fn ($query) => $query->where('company_id', $request->company_id))
            ->when($request->filled('brand_id'), fn ($query) => $query->where('brand_id', $request->brand_id))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->with('company', 'category', 'brand', 'images', 'videos')
            ->orderBy('name')
            ->paginate($request->get('per_page', 15));

        return response()->json($products);
    }

    public function show(Product $product)
    {
        $product->load([
            'company',
            'category',
            'brand',
            'images',
            'videos',
            'locations.location',
            'productSizes.size',
            'productColors.color',
        ]);

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $company_id = $request->user()->company_id ?? $request->input('company_id');

        $validated = $request->validate([
            'company_id' => 'required|integer|exists:companies,id',
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')->where('company_id', $company_id)],
            'brand_id' => ['required', 'integer', Rule::exists('brands', 'id')->where('company_id', $company_id)],
            'name' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('products', 'slug')],
            'description' => 'nullable|string',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'images' => 'required|array|min:5|max:20',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'video' => 'nullable|file|mimes:mp4,avi,mov,mkv|max:102400',
            'video_type' => ['nullable', Rule::in(['youtube', 'vimeo', 'local'])],
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'cost_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'minimum_order_quantity' => 'nullable|integer|min:1',
            'unit' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric|min:0',
            'status' => ['nullable', Rule::in(['draft', 'published', 'out_of_stock', 'inactive'])],
            'featured' => 'nullable|boolean',
            'images' => 'sometimes|required|array|min:1|max:20',
            'images.*' => 'required_with:images|image|mimes:jpeg,png,jpg,gif|max:5120',
            'primary_image_index' => 'nullable|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'variants' => 'sometimes|array',
            'variants.*.size' => 'nullable|string|max:255',
            'variants.*.color' => 'nullable|string|max:255',
            'variants.*.sku' => 'nullable|string|max:255',
            'variants.*.barcode' => 'nullable|string|max:255',
            'variants.*.quantity' => 'nullable|integer|min:0',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.discount_price' => 'nullable|numeric|min:0',
            'variants.*.cost_price' => 'nullable|numeric|min:0',
        ]);

        try {
            return DB::transaction(function () use ($request, $validated) {
                $data = $validated;
                $data['slug'] = $data['slug'] ?? Str::slug($data['name']);
                $data['status'] = $data['status'] ?? 'draft';
                $data['quantity'] = $data['quantity'] ?? 0;
                $data['minimum_order_quantity'] = $data['minimum_order_quantity'] ?? 1;
                $data['unit'] = $data['unit'] ?? 'pcs';
                $data['featured'] = $data['featured'] ?? false;

                $product = Product::create($data);

                if ($request->hasFile('images')) {
                    $this->processProductImages($product, $request);
                }

                if ($request->hasFile('video')) {
                    $this->processProductVideo($product, $request);
                }

                $this->processProductVariants($product, $request);

                Log::info('Product created', array_merge($this->actionLogContext($request), [
                    'product_id' => $product->id,
                    'name' => $product->name,
                    'total_stock' => $product->total_stock,
                ]));

                return response()->json([
                    'message' => 'Product created successfully',
                    'product' => $product->load([
                        'company',
                        'category',
                        'brand',
                        'images',
                        'videos',
                        'locations.location',
                        'productSizes.size',
                        'productColors.color',
                    ]),
                ], 201);
            });
        } catch (\Exception $e) {
            Log::error('Product creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'message' => 'Failed to create product',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, Product $product)
    {
        $company_id = $request->user()->company_id ?? $product->company_id;

        $validated = $request->validate([
            'category_id' => ['sometimes', 'integer', Rule::exists('categories', 'id')->where('company_id', $company_id)],
            'brand_id' => ['sometimes', 'integer', Rule::exists('brands', 'id')->where('company_id', $company_id)],
            'name' => 'sometimes|string|max:255',
            'slug' => ['sometimes', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product->id)],
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'cost_price' => 'nullable|numeric|min:0',
            'total_stock' => 'sometimes|integer|min:0',
            'status' => ['nullable', Rule::in(['draft', 'active', 'inactive', 'discontinued'])],
            'is_featured' => 'nullable|boolean',
            'meta_description' => 'nullable|string|max:255',
            'meta_keywords' => 'nullable|string',
        ]);

        try {
            $product->update($validated);

            Log::info('Product updated', array_merge($this->actionLogContext($request), [
                'product_id' => $product->id,
                'updated_fields' => array_keys($validated),
            ]));

            return response()->json([
                'message' => 'Product updated successfully',
                'product' => $product->load([
                    'company',
                    'category',
                    'brand',
                    'images',
                    'videos',
                    'locations.location',
                    'productSizes.size',
                    'productColors.color',
                ]),
            ]);
        } catch (\Exception $e) {
            Log::error('Product update failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to update product',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy(Product $product)
    {
        try {
            return DB::transaction(function () use ($product) {
                // Delete images
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image->image_url);
                    $image->delete();
                }

                // Delete videos
                foreach ($product->videos as $video) {
                    Storage::disk('public')->delete($video->video_url);
                    $video->delete();
                }

                // Delete location associations
                $product->locations()->delete();

                // Delete size associations
                $product->productSizes()->delete();

                // Delete color associations
                $product->productColors()->delete();

                // Delete product
                $product->delete();

                Log::info('Product deleted', array_merge($this->actionLogContext(), [
                    'product_id' => $product->id,
                    'name' => $product->name,
                ]));

                return response()->json([
                    'message' => 'Product deleted successfully',
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Product deletion failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to delete product',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Upload additional product images
     */
    public function uploadImages(Request $request, Product $product)
    {
        $validated = $request->validate([
            'images' => 'required|array|min:1|max:20',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        try {
            $uploadedImages = [];
            $maxSortOrder = $product->images()->max('sort_order') ?? 0;

            foreach ($validated['images'] as $index => $image) {
                $imagePath = $this->uploadImage($image);
                $productImage = $product->images()->create([
                    'image_url' => $imagePath,
                    'alt_text' => $product->name . ' - Image ' . ($maxSortOrder + $index + 1),
                    'sort_order' => $maxSortOrder + $index + 1,
                    'is_featured' => false,
                ]);
                $uploadedImages[] = $productImage;
            }

            Log::info('Product images uploaded', array_merge($this->actionLogContext($request), [
                'product_id' => $product->id,
                'images_count' => count($uploadedImages),
            ]));

            return response()->json([
                'message' => count($uploadedImages) . ' images uploaded successfully',
                'images' => $uploadedImages,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Product image upload failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to upload images',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Upload product video
     */
    public function uploadVideo(Request $request, Product $product)
    {
        $validated = $request->validate([
            'video' => 'required|file|mimes:mp4,avi,mov,mkv|max:102400',
            'video_type' => ['required', Rule::in(['youtube', 'vimeo', 'local'])],
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $videoPath = $this->uploadVideoFile($request->file('video'));

            $productVideo = $product->videos()->create([
                'video_url' => $videoPath,
                'title' => $validated['title'] ?? $product->name . ' - Video',
                'description' => $validated['description'] ?? null,
                'video_type' => $validated['video_type'],
            ]);

            Log::info('Product video uploaded', array_merge($this->actionLogContext($request), [
                'product_id' => $product->id,
                'video_id' => $productVideo->id,
            ]));

            return response()->json([
                'message' => 'Video uploaded successfully',
                'video' => $productVideo,
            ], 201);
        } catch (\Exception $e) {
            Log::error('Product video upload failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to upload video',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a specific product image
     */
    public function deleteImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            return response()->json(['message' => 'Image not found for this product'], 404);
        }

        try {
            Storage::disk('public')->delete($image->image_url);
            $image->delete();

            Log::info('Product image deleted', array_merge($this->actionLogContext(), [
                'product_id' => $product->id,
                'image_id' => $image->id,
            ]));

            return response()->json([
                'message' => 'Image deleted successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Product image deletion failed', [
                'product_id' => $product->id,
                'image_id' => $image->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to delete image',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete a specific product video
     */
    public function deleteVideo(Product $product, ProductVideo $video)
    {
        if ($video->product_id !== $product->id) {
            return response()->json(['message' => 'Video not found for this product'], 404);
        }

        try {
            Storage::disk('public')->delete($video->video_url);
            $video->delete();

            Log::info('Product video deleted', array_merge($this->actionLogContext(), [
                'product_id' => $product->id,
                'video_id' => $video->id,
            ]));

            return response()->json([
                'message' => 'Video deleted successfully',
            ]);
        } catch (\Exception $e) {
            Log::error('Product video deletion failed', [
                'product_id' => $product->id,
                'video_id' => $video->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to delete video',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Set product locations with quantities
     */
    public function setLocations(Request $request, Product $product)
    {
        $validated = $request->validate([
            'locations' => 'required|array|min:1',
            'locations.*.location_id' => 'required|integer|exists:company_locations,id',
            'locations.*.quantity' => 'required|integer|min:0',
            'locations.*.is_visible' => 'nullable|boolean',
        ]);

        $locationStockSum = collect($validated['locations'])->sum('quantity');
        if ($locationStockSum !== $product->total_stock) {
            return response()->json([
                'message' => 'Location stock quantities must sum to total stock',
                'total_stock' => $product->total_stock,
                'sum_from_locations' => $locationStockSum,
            ], 422);
        }

        try {
            return DB::transaction(function () use ($product, $validated) {
                $product->locations()->delete();

                foreach ($validated['locations'] as $location) {
                    $product->locations()->create([
                        'location_id' => $location['location_id'],
                        'quantity' => $location['quantity'],
                        'is_visible' => $location['is_visible'] ?? true,
                    ]);
                }

                Log::info('Product locations updated', array_merge($this->actionLogContext(), [
                    'product_id' => $product->id,
                    'locations_count' => count($validated['locations']),
                ]));

                return response()->json([
                    'message' => 'Product locations updated successfully',
                    'locations' => $product->locations()->with('location')->get(),
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Product locations update failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to update locations',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Set product sizes with quantities
     */
    public function setSizes(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sizes' => 'required|array|min:1',
            'sizes.*.size_id' => 'required|integer|exists:sizes,id',
            'sizes.*.quantity' => 'required|integer|min:0',
        ]);

        $sizeStockSum = collect($validated['sizes'])->sum('quantity');
        if ($sizeStockSum !== $product->total_stock) {
            return response()->json([
                'message' => 'Size stock quantities must sum to total stock',
                'total_stock' => $product->total_stock,
                'sum_from_sizes' => $sizeStockSum,
            ], 422);
        }

        try {
            return DB::transaction(function () use ($product, $validated) {
                $product->productSizes()->delete();

                foreach ($validated['sizes'] as $size) {
                    $product->productSizes()->create([
                        'size_id' => $size['size_id'],
                        'quantity' => $size['quantity'],
                    ]);
                }

                Log::info('Product sizes updated', array_merge($this->actionLogContext(), [
                    'product_id' => $product->id,
                    'sizes_count' => count($validated['sizes']),
                ]));

                return response()->json([
                    'message' => 'Product sizes updated successfully',
                    'sizes' => $product->productSizes()->with('size')->get(),
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Product sizes update failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to update sizes',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Set product colors with quantities
     */
    public function setColors(Request $request, Product $product)
    {
        $validated = $request->validate([
            'colors' => 'required|array|min:1',
            'colors.*.color_id' => 'required|integer|exists:colors,id',
            'colors.*.quantity' => 'required|integer|min:0',
        ]);

        $colorStockSum = collect($validated['colors'])->sum('quantity');
        if ($colorStockSum !== $product->total_stock) {
            return response()->json([
                'message' => 'Color stock quantities must sum to total stock',
                'total_stock' => $product->total_stock,
                'sum_from_colors' => $colorStockSum,
            ], 422);
        }

        try {
            return DB::transaction(function () use ($product, $validated) {
                $product->productColors()->delete();

                foreach ($validated['colors'] as $color) {
                    $product->productColors()->create([
                        'color_id' => $color['color_id'],
                        'quantity' => $color['quantity'],
                    ]);
                }

                Log::info('Product colors updated', array_merge($this->actionLogContext(), [
                    'product_id' => $product->id,
                    'colors_count' => count($validated['colors']),
                ]));

                return response()->json([
                    'message' => 'Product colors updated successfully',
                    'colors' => $product->productColors()->with('color')->get(),
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Product colors update failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' => 'Failed to update colors',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Helper method to upload an image file
     */
    private function uploadImage($imageFile)
    {
        $filename = time() . '_' . Str::random(20) . '.' . $imageFile->getClientOriginalExtension();
        return $imageFile->storeAs('products/images', $filename, 'public');
    }

    /**
     * Helper method to upload a video file
     */
    private function uploadVideoFile($videoFile)
    {
        $filename = time() . '_' . Str::random(20) . '.' . $videoFile->getClientOriginalExtension();
        return $videoFile->storeAs('products/videos', $filename, 'public');
    }
}
