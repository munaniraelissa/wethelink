<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'barcode',
        'short_description',
        'description',
        'featured_image',
        'price',
        'discount_price',
        'cost_price',
        'quantity',
        'minimum_order_quantity',
        'unit',
        'weight',
        'status',
        'featured',
        'is_featured',
        'views',
        'view_count',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'quantity' => 'integer',
        'minimum_order_quantity' => 'integer',
        'weight' => 'decimal:2',
        'featured' => 'boolean',
        'is_featured' => 'boolean',
        'views' => 'integer',
        'view_count' => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // Images & Videos
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function videos()
    {
        return $this->hasMany(ProductVideo::class);
    }

    // Locations
    public function locations()
    {
        return $this->hasMany(ProductLocation::class);
    }

    public function companyLocations()
    {
        return $this->belongsToMany(CompanyLocation::class, 'product_locations')
            ->withPivot('quantity', 'is_visible')
            ->withTimestamps();
    }

    // Sizes
    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class, 'product_sizes')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    // Colors
    public function productColors()
    {
        return $this->hasMany(ProductColor::class);
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_colors')
            ->withPivot('quantity')
            ->withTimestamps();
    }

    // Variants (legacy support)
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    // Helper methods
    public function primaryImage()
    {
        return $this->images()->where('is_featured', true)->first()
            ?? $this->images()->first();
    }

    public function getTotalStockFromLocations()
    {
        return $this->locations()->sum('quantity');
    }

    public function getTotalStockFromSizes()
    {
        return $this->productSizes()->sum('quantity');
    }

    public function getTotalStockFromColors()
    {
        return $this->productColors()->sum('quantity');
    }

    public function validateStock()
    {
        $fromLocations = $this->getTotalStockFromLocations();
        $fromSizes = $this->getTotalStockFromSizes();
        $fromColors = $this->getTotalStockFromColors();

        return ($fromLocations === $this->total_stock)
               && ($fromSizes === $this->total_stock)
               && ($fromColors === $this->total_stock);
    }

    public function findVariant(?int $variantId = null, ?string $size = null, ?string $color = null)
    {
        return $this->variants()
            ->when($variantId, fn ($query) => $query->where('id', $variantId))
            ->when($size, fn ($query) => $query->where('size', $size))
            ->when($color, fn ($query) => $query->where('color', $color))
            ->first();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
