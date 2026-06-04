<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'code',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function productSizes()
    {
        return $this->hasMany(ProductSize::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_sizes')
            ->withPivot('quantity')
            ->withTimestamps();
    }
}
