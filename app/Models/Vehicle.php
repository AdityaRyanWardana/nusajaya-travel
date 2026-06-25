<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'armada_id',
        'plate_number',
        'mirror_number',
        'status',
        'notes',
    ];

    public function armada()
    {
        return $this->belongsTo(Armada::class);
    }
}
