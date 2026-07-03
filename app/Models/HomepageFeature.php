<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageFeature extends Model
{
    protected $fillable = [
        'title',
        'icon_class',
        'description',
        'sort_order',
        'is_active',
    ];
}
