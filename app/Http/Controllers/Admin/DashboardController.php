<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\Armada;
use App\Models\Tour;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_armada' => Armada::sum('total_units'),
            'available_armada' => Armada::sum('total_units') - Armada::sum('maintenance_units'),
            'maintenance_armada' => Armada::sum('maintenance_units'),
            'total_tours' => Tour::count(),
            'recent_bookings' => Booking::with('user')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
