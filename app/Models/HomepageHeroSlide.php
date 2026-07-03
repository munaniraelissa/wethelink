<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomepageHeroSlide extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'button_text',
        'button_url',
        'image_path',
        'sort_order',
        'is_active',
    ];
}
