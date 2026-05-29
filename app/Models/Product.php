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
        'name',
        'slug',
        'sku',
        'barcode',
        'short_description',
        'description',
        'price',
        'discount_price',
        'cost_price',
        'quantity',
        'minimum_order_quantity',
        'unit',
        'weight',
        'status',
        'featured',
        'video',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'quantity' => 'integer',
        'minimum_order_quantity' => 'integer',
        'weight' => 'decimal:2',
        'featured' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function videos()
    {
        return $this->hasMany(ProductVideo::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function findVariant(?int $variantId = null, ?string $size = null, ?string $color = null)
    {
        return $this->variants()
            ->when($variantId, fn ($query) => $query->where('id', $variantId))
            ->when($size, fn ($query) => $query->where('size', $size))
            ->when($color, fn ($query) => $query->where('color', $color))
            ->first();
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }
}
