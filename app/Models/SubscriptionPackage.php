<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPackage extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'pricing_monthly',
        'pricing_yearly',
        'max_locations',
        'max_users',
        'features',
        'billing_cycle_days',
        'status',
    ];

    protected $casts = [
        'pricing_monthly' => 'decimal:2',
        'pricing_yearly' => 'decimal:2',
        'max_locations' => 'integer',
        'max_users' => 'integer',
        'features' => 'array',
        'billing_cycle_days' => 'integer',
    ];

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }
}

