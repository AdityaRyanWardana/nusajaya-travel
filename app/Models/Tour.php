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
        'armada_id',
        'duration',
        'image',
        'images',
        'inclusions',
        'description',
    ];

    protected $casts = [
        'images' => 'array',
        'inclusions' => 'array',
    ];

    public function armada()
    {
        return $this->belongsTo(Armada::class);
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
