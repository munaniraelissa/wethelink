<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'company_id',
        'subscription_package_id',
        'status',
        'approval_status',
        'started_at',
        'ends_at',
        'renewal_date',
        'auto_renew',
        'amount_paid',
        'current_location_count',
        'current_user_count',
        'approved_at',
        'rejected_at',
        'rejection_reason',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'current_location_count' => 'integer',
        'current_user_count' => 'integer',
        'auto_renew' => 'boolean',
        'started_at' => 'datetime',
        'ends_at' => 'datetime',
        'renewal_date' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function package()
    {
        return $this->belongsTo(SubscriptionPackage::class, 'subscription_package_id');
    }

    public function histories()
    {
        return $this->hasMany(SubscriptionHistory::class);
    }

    public function isActive()
    {
        return $this->approval_status === 'approved' && $this->status === 'active';
    }

    public function isLocationLimitReached()
    {
        return $this->current_location_count >= $this->package->max_locations;
    }
}

