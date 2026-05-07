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
}
