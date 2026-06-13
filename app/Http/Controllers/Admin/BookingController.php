<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with('user');

        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->where(function($q) {
                    $q->where('status', 'pending')
                      ->orWhere(function($sq) {
                          $sq->where('reschedule_notified', false)
                             ->whereNotNull('rescheduled_at');
                      });
                });
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->filled('month')) {
            $parts = explode('-', $request->month);
            if (count($parts) === 2) {
                $query->whereYear('created_at', $parts[0])
                      ->whereMonth('created_at', $parts[1]);
            }
        }

        $bookings = $query->latest()->paginate(15)->appends($request->query());
        
        $counts = [
            'pending' => Booking::where('status', 'pending')->orWhere(function($sq) {
                            $sq->where('reschedule_notified', false)->whereNotNull('rescheduled_at');
                        })->count(),
            'paid' => Booking::where('status', 'paid')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        return view('admin.bookings.index', compact('bookings', 'counts'));
    }

    public function show(Booking $booking)
    {
        $booking->load('user');
        return view('admin.bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        if (auth()->user()->role === 'superadmin') {
            abort(403, 'Superadmin has Audit Only access and cannot modify bookings.');
        }

        $request->validate([
            'status' => 'required|in:pending,paid,cancelled'
        ]);

        $booking->update(['status' => $request->status]);

        return back()->with('success', 'Booking status updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        if (auth()->user()->role === 'superadmin') {
            abort(403, 'Superadmin has Audit Only access and cannot modify bookings.');
        }

        $booking->delete();
        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }
}
