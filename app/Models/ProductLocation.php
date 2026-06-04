<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductLocation extends Model
{
    protected $fillable = [
        'product_id',
        'location_id',
        'quantity',
        'is_visible',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'is_visible' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function location()
    {
        return $this->belongsTo(CompanyLocation::class);
    }
}
