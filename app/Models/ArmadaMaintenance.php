<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArmadaMaintenance extends Model
{
    protected $fillable = [
        'armada_id',
        'vehicle_name',
        'expected_finish_date',
        'status',
    ];

    protected $casts = [
        'expected_finish_date' => 'date',
    ];

    public function armada()
    {
        return $this->belongsTo(Armada::class);
    }
}
