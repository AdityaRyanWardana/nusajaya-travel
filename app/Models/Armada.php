<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Armada extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'capacity',
        'price_per_day',
        'price_city_tour',
        'price_city_one_way',
        'price_city_half_day',
        'price_city_one_day',
        'price_city_full_day',
        'price_barelang',
        'image',
        'images',
        'description',
        'total_units',
    ];

    protected $casts = [
        'images' => 'array',
    ];
}
