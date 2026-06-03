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
        $armadas = Armada::orderBy('price_barelang', 'asc')->get();
        
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
            'travel_date' => 'required|date|after_or_equal:today',
            'category' => 'required|string',
            'pickup_point' => 'nullable|string',
            'duration' => 'nullable|string',
            'pickup_time' => 'required|string',
            'guests' => 'nullable|integer|min:1',
            'participants' => 'nullable|array',
            'customer_phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $travelDate = \Carbon\Carbon::parse($request->travel_date)->startOfDay();
        $today = \Carbon\Carbon::today();

        if ($travelDate->isSameDay($today)) {
            $timeStr = \Carbon\Carbon::now()->format('H:i');

            if (str_contains($request->pickup_time, 'Morning') && $timeStr > '11:00') {
                return back()->withErrors(['pickup_time' => 'Sesi Morning (08:00-11:00) sudah lewat untuk hari ini. Silakan pilih sesi lain atau pesan untuk besok.'])->withInput();
            }

            if (str_contains($request->pickup_time, 'Afternoon') && $timeStr > '15:00') {
                return back()->withErrors(['pickup_time' => 'Sesi Afternoon (12:00-15:00) sudah lewat untuk hari ini. Silakan pesan untuk besok.'])->withInput();
            }

            if (str_contains($request->pickup_time, 'Evening') && $timeStr > '20:00') {
                return back()->withErrors(['pickup_time' => 'Sesi Evening (17:00-20:00) sudah lewat untuk hari ini. Silakan pesan untuk besok.'])->withInput();
            }
        }

        $participants = $request->participants;
        if (!$participants || count($participants) === 0) {
            $participants = [
                [
                    'salutation' => 'Mr',
                    'name' => auth()->user()->name,
                    'identity' => 'Account Holder'
                ]
            ];
        }

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
            'armada_id' => $transport->id,
            'type' => 'transport',
            'amount' => $price,
            'guests' => $request->guests ?? 1,
            'travel_date' => $request->travel_date,
            'pickup_point' => $request->pickup_point,
            'destination' => $request->destination ?? $request->category,
            'pickup_time' => $request->pickup_time,
            'customer_details' => [
                'names' => $participants,
                'phone' => $request->customer_phone,
                'notes' => $request->notes,
            ],
            'status' => 'pending'
        ]);

        return redirect()->route('orders.payment', $booking->id)->with('success', 'Booking transport successful! Please complete your payment.');
    }
}
