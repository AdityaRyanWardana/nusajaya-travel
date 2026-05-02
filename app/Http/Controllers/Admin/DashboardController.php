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
        $currentMonthBookings = Booking::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
            
        $lastMonthBookings = Booking::whereMonth('created_at', now()->subMonth()->month)
            ->whereYear('created_at', now()->subMonth()->year)
            ->count();

        $growth = 0;
        if ($lastMonthBookings > 0) {
            $growth = (($currentMonthBookings - $lastMonthBookings) / $lastMonthBookings) * 100;
        } elseif ($currentMonthBookings > 0) {
            $growth = 100; // If there were 0 last month and > 0 now, it's 100% growth
        }

        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'total_armada' => Armada::sum('total_units'),
            'available_armada' => Armada::sum('total_units') - Armada::sum('maintenance_units'),
            'maintenance_armada' => Armada::sum('maintenance_units'),
            'total_tours' => Tour::count(),
            'recent_bookings' => Booking::with('user')->latest()->take(5)->get(),
            'booking_growth' => round($growth, 1),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
