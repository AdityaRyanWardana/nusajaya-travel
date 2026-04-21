<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Armada;
use App\Models\Booking;

class TransportController extends Controller
{
    public function index(Request $request)
    {
        $selectedDate = $request->query('date', now()->format('Y-m-d'));
        
        // Ambil data armada dari database
        $armadas = Armada::all();
        
        // Cek ketersediaan berdasarkan booking
        $bookedSlugs = Booking::where('type', 'transport')
            ->whereDate('travel_date', $selectedDate)
            ->whereIn('status', ['pending', 'paid'])
            ->pluck('service_slug')
            ->toArray();

        foreach ($armadas as $armada) {
            $armada->available = !in_array($armada->slug, $bookedSlugs);
        }

        return view('transport.index', [
            'transports' => $armadas,
            'selectedDate' => $selectedDate
        ]);
    }

    public function show($slug)
    {
        $transport = Armada::where('slug', $slug)->firstOrFail();
        return view('transport.show', compact('transport'));
    }

    public function book(Request $request, $id)
    {
        $request->validate([
            'travel_date' => 'required|date'
        ]);

        $transport = Armada::findOrFail($id);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'service_name' => $transport->name . ' - PP Barelang',
            'service_slug' => $transport->slug,
            'type' => 'transport',
            'amount' => $transport->price_per_day,
            'travel_date' => $request->travel_date,
            'status' => 'pending'
        ]);

        return redirect()->route('orders.payment', $booking->id)->with('success', 'Booking transport successful! Please complete your payment.');
    }
}
