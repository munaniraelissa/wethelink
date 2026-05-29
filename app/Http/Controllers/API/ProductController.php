<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    use ActionLogTrait;

    public function index(Request $request)
    {
        $products = Product::query()
            ->when($request->filled('category_id'), fn ($query) => $query->where('category_id', $request->category_id))
            ->when($request->filled('company_id'), fn ($query) => $query->where('company_id', $request->company_id))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->status))
            ->with('images', 'videos', 'category')
            ->orderBy('name')
            ->paginate($request->get('per_page', 15));

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'company_id' => 'required|integer|exists:companies,id',
            'category_id' => 'required|integer|exists:categories,id',
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:products,slug',
            'sku' => 'required|string|max:255|unique:products,sku',
            'barcode' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'minimum_order_quantity' => 'nullable|integer|min:1',
            'unit' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric|min:0',
            'status' => ['nullable', Rule::in(['draft', 'published', 'out_of_stock', 'inactive'])],
            'featured' => 'nullable|boolean',
            'images' => 'sometimes|required|array|min:5|max:10',
            'images.*' => 'required_with:images|image|mimes:jpeg,png,jpg,gif|max:5120',
            'primary_image_index' => 'nullable|integer|min:0|max:9',
            'video' => 'nullable|file|mimes:mp4,avi,mov,mkv|max:102400',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

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

        Log::info('Product created', array_merge($this->actionLogContext($request), [
            'product_id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
        ]));

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product->load('images', 'videos'),
        ], 201);
    }

    public function show(Product $product)
    {
        $product->load('images', 'videos', 'category', 'company');
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => 'sometimes|required|integer|exists:categories,id',
            'name' => 'sometimes|required|string|max:255',
            'slug' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('products', 'slug')->ignore($product->id)],
            'sku' => ['sometimes', 'required', 'string', 'max:255', Rule::unique('products', 'sku')->ignore($product->id)],
            'barcode' => 'nullable|string|max:255',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'sometimes|required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'quantity' => 'nullable|integer|min:0',
            'minimum_order_quantity' => 'nullable|integer|min:1',
            'unit' => 'nullable|string|max:50',
            'weight' => 'nullable|numeric|min:0',
            'status' => ['nullable', Rule::in(['draft', 'published', 'out_of_stock', 'inactive'])],
            'featured' => 'nullable|boolean',
            'images' => 'sometimes|array|min:1|max:10',
            'images.*' => 'required_with:images|image|mimes:jpeg,png,jpg,gif|max:5120',
            'primary_image_index' => 'nullable|integer|min:0|max:9',
            'video' => 'nullable|file|mimes:mp4,avi,mov,mkv|max:102400',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if (!isset($data['slug']) && isset($data['name'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        $product->update($data);

        if ($request->hasFile('images')) {
            $this->processProductImages($product, $request);
        }

        if ($request->hasFile('video')) {
            $this->processProductVideo($product, $request);
        }

        Log::info('Product updated', array_merge($this->actionLogContext($request), [
            'product_id' => $product->id,
            'updated' => array_keys($data),
        ]));

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product->load('images', 'videos'),
        ]);
    }

    protected function processProductImages(Product $product, Request $request): array
    {
        $primaryImageIndex = $request->input('primary_image_index', 0);
        $uploadedImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $filename = time() . '_' . Str::random(20) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products/images', $filename, 'public');

                $isPrimary = ($index === $primaryImageIndex);

                if ($isPrimary) {
                    $product->images()->update(['is_primary' => false]);
                }

                $productImage = $product->images()->create([
                    'image' => $path,
                    'is_primary' => $isPrimary,
                ]);

                $uploadedImages[] = $productImage;
            }
        }

        return $uploadedImages;
    }

    protected function processProductVideo(Product $product, Request $request)
    {
        $videoPath = null;
        $thumbnailPath = null;

        if ($request->hasFile('video')) {
            $filename = time() . '_' . Str::random(20) . '.' . $request->file('video')->getClientOriginalExtension();
            $videoPath = $request->file('video')->storeAs('products/videos', $filename, 'public');

            if ($request->hasFile('thumbnail')) {
                $thumbFilename = time() . '_thumb_' . Str::random(20) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
                $thumbnailPath = $request->file('thumbnail')->storeAs('products/videos/thumbnails', $thumbFilename, 'public');
            }

            return $product->videos()->create([
                'video' => $videoPath,
                'thumbnail' => $thumbnailPath,
            ]);
        }

        return null;
    }

    public function destroy(Product $product)
    {
        // Delete product images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        // Delete product videos from storage
        foreach ($product->videos as $video) {
            Storage::disk('public')->delete($video->video);
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }
        }

        $product->delete();

        Log::info('Product deleted', array_merge($this->actionLogContext(), [
            'product_id' => $product->id,
            'name' => $product->name,
        ]));

        return response()->json([
            'message' => 'Product deleted successfully',
        ]);
    }

    /**
     * Upload product images (at least 5 required)
     */
    public function uploadImages(Request $request, Product $product)
    {
        $request->validate([
            'images' => 'required|array|min:5|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB per image
            'primary_image_index' => 'nullable|integer|min:0|max:9',
        ]);

        try {
            $primaryImageIndex = $request->input('primary_image_index', 0);
            $uploadedImages = [];

            foreach ($request->file('images') as $index => $image) {
                $filename = time() . '_' . Str::random(20) . '.' . $image->getClientOriginalExtension();
                $path = $image->storeAs('products/images', $filename, 'public');

                $isPrimary = ($index === $primaryImageIndex);

                // If this is primary, set others to false
                if ($isPrimary) {
                    $product->images()->update(['is_primary' => false]);
                }

                $productImage = $product->images()->create([
                    'image' => $path,
                    'is_primary' => $isPrimary,
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
        $request->validate([
            'video' => 'required|file|mimes:mp4,avi,mov,mkv|max:102400', // 100MB for video
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Optional thumbnail
        ]);

        try {
            $filename = time() . '_' . Str::random(20) . '.' . $request->file('video')->getClientOriginalExtension();
            $videoPath = $request->file('video')->storeAs('products/videos', $filename, 'public');

            $thumbnailPath = null;
            if ($request->hasFile('thumbnail')) {
                $thumbFilename = time() . '_thumb_' . Str::random(20) . '.' . $request->file('thumbnail')->getClientOriginalExtension();
                $thumbnailPath = $request->file('thumbnail')->storeAs('products/videos/thumbnails', $thumbFilename, 'public');
            }

            $productVideo = $product->videos()->create([
                'video' => $videoPath,
                'thumbnail' => $thumbnailPath,
            ]);

            Log::info('Product video uploaded', array_merge($this->actionLogContext($request), [
                'product_id' => $product->id,
                'video_id' => $productVideo->id,
                'video_path' => $videoPath,
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
     * Delete a specific product video
     */
    public function deleteVideo(Product $product, ProductVideo $video)
    {
        if ($video->product_id !== $product->id) {
            return response()->json(['message' => 'Video not found for this product'], 404);
        }

        Storage::disk('public')->delete($video->video);
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }

        $video->delete();

        Log::info('Product video deleted', array_merge($this->actionLogContext(), [
            'product_id' => $product->id,
            'video_id' => $video->id,
        ]));

        return response()->json([
            'message' => 'Video deleted successfully',
        ]);
    }

    /**
     * Delete a specific product image
     */
    public function deleteImage(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            return response()->json(['message' => 'Image not found for this product'], 404);
        }

        Storage::disk('public')->delete($image->image);
        $image->delete();

        Log::info('Product image deleted', array_merge($this->actionLogContext(), [
            'product_id' => $product->id,
            'image_id' => $image->id,
        ]));

        return response()->json([
            'message' => 'Image deleted successfully',
        ]);
    }

    /**
     * Set primary image
     */
    public function setPrimaryImage(Request $request, Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            return response()->json(['message' => 'Image not found for this product'], 404);
        }

        // Set all images to non-primary
        $product->images()->update(['is_primary' => false]);

        // Set this image as primary
        $image->update(['is_primary' => true]);

        Log::info('Primary image updated', array_merge($this->actionLogContext($request), [
            'product_id' => $product->id,
            'image_id' => $image->id,
        ]));

        return response()->json([
            'message' => 'Primary image updated successfully',
            'image' => $image,
        ]);
    }
}
