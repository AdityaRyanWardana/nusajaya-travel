<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'destination',
        'price',
        'duration',
        'image',
        'images',
        'description',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
