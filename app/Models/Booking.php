<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'service_name', 'service_slug', 'type', 'amount', 'guests', 'travel_date', 'status'])]
class Booking extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
