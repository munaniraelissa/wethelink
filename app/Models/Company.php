<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'email',
        'telephone',
        'website',
        'logo',
        'tax_number',
        'registration_number',
        'industry',
        'credit_limit',
        'payment_terms_days',
        'status',
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'payment_terms_days' => 'integer',
    ];

    public function locations()
    {
        return $this->hasMany(CompanyLocation::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
