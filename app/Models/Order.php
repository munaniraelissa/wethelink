<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'company_location_id',
        'order_number',
        'company_id',
        'user_id',
        'subtotal',
        'tax',
        'shipping_cost',
        'discount',
        'total',
        'payment_status',
        'status',
        'shipping_name',
        'shipping_phone',
        'shipping_address',
        'notes',
        'approved_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount' => 'decimal:2',
        'total' => 'decimal:2',
        'approved_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function location()
    {
        return $this->belongsTo(CompanyLocation::class, 'company_location_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
