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
        'maintenance_units',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function maintenances()
    {
        return $this->hasMany(ArmadaMaintenance::class);
    }

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }

        if (\Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        if (\Str::startsWith($this->image, 'images/')) {
            return asset($this->image);
        }

        return asset('storage/' . $this->image);
    }
}
