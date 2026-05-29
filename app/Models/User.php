<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
     use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'company_id',
        'firstname',
        'lastname',
        'othername',
        'gender',
        'id_number',
        'date_of_birth',
        'telephone',
        'alternative_phone',
        'email',
        'password',
        'avatar',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    public function company()
        {
            return $this->belongsTo(Company::class);
        }

        public function location()
        {
            return $this->belongsTo(CompanyLocation::class);
        }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_of_birth' => 'date',
            'password' => 'hashed',
        ];
    }
}