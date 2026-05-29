<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyLocation extends Model
{
    protected $fillable = [
        'company_id',
        'name',
        'email',
        'telephone',
        'manager_name',
        'country',
        'province',
        'district',
        'city',
        'address',
        'latitude',
        'longitude',
        'is_head_office',
        'status',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
