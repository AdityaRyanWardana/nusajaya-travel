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
        $bookingCounts = Booking::where('type', 'transport')
            ->whereDate('travel_date', $selectedDate)
            ->whereIn('status', ['pending', 'paid', 'completed']) // Include completed if you don't want double booking
            ->select('service_slug', \Illuminate\Support\Facades\DB::raw('count(*) as count'))
            ->groupBy('service_slug')
            ->pluck('count', 'service_slug')
            ->toArray();

        foreach ($armadas as $armada) {
            $bookedCount = $bookingCounts[$armada->slug] ?? 0;
            $armada->available = $bookedCount < $armada->total_units;
            $armada->units_left = $armada->total_units - $bookedCount;
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
            'travel_date' => 'required|date',
            'category' => 'required|string',
            'pickup_point' => 'nullable|string',
            'duration' => 'nullable|string',
            'pickup_time' => 'required|string'
        ]);

        $transport = Armada::findOrFail($id);
        
        $price = 0;
        $serviceName = $transport->name . ' - ' . $request->category;

        if ($request->category === 'PP Barelang') {
            $price = $transport->price_barelang;
        } elseif ($request->category === 'Transfer Only') {
            $price = $transport->price_city_one_way;
            $serviceName = $transport->name . ' - Transfer One Way';
        } else {
            $duration = $request->duration ?? 'one_day';
            $priceKey = 'price_city_' . $duration;
            $price = $transport->$priceKey ?? 0;
            $serviceName .= ' (' . str_replace('_', ' ', $duration) . ')';
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'service_name' => $serviceName,
            'service_slug' => $transport->slug,
            'type' => 'transport',
            'amount' => $price,
            'travel_date' => $request->travel_date,
            'pickup_point' => $request->pickup_point,
            'destination' => $request->destination ?? $request->category,
            'pickup_time' => $request->pickup_time,
            'status' => 'pending'
        ]);

        return redirect()->route('orders.payment', $booking->id)->with('success', 'Booking transport successful! Please complete your payment.');
    }
}
