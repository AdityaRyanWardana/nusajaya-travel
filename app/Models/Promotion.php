<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'badge',
        'type',
        'link',
        'link_text',
        'is_active',
        'expires_at',
        'tour_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'expires_at' => 'datetime',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
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
