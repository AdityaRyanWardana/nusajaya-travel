<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'service_name', 'service_slug', 'type', 'amount', 'guests', 'travel_date', 'status', 'pickup_point', 'destination', 'pickup_time'])]
class Booking extends Model
{
    protected $casts = [
        'travel_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getOrderNumberAttribute(): string
    {
        $date = $this->created_at ? $this->created_at->format('Ymd') : now()->format('Ymd');
        return 'NJ-' . $date . '-' . str_pad($this->id, 4, '0', STR_PAD_LEFT);
    }
}
