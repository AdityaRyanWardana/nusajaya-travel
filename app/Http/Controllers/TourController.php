<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tour;
use App\Models\Booking;

class TourController extends Controller
{
    public function index(Request $request)
    {
        $category = $request->query('category');
        
        $query = Tour::query();

        if ($category && $category !== 'All') {
            $query->where('destination', 'like', '%' . $category . '%');
        }

        $tours = $query->latest()->get();

        return view('tours.index', [
            'tours' => $tours,
            'selectedCategory' => $category ?: 'All'
        ]);
    }

    public function show($slug)
    {
        $tour = Tour::where('slug', $slug)->firstOrFail();
        return view('tours.show', compact('tour'));
    }

    public function book(Request $request, $id)
    {
        $request->validate([
            'date' => 'required|date|after_or_equal:today',
            'guests' => 'required|integer|min:1',
            'pickup_point' => 'required|string',
            'participants' => 'required|array',
            'participants.*.salutation' => 'required|string',
            'participants.*.name' => 'required|string|max:255',
            'participants.*.identity' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'notes' => 'nullable|string',
        ]);

        $travelDate = \Carbon\Carbon::parse($request->date)->startOfDay();
        $today = \Carbon\Carbon::today();

        if ($travelDate->isSameDay($today)) {
            $timeStr = \Carbon\Carbon::now()->format('H:i');
            
            // For tours, assume departure is morning (08:00 cutoff)
            if ($timeStr > '08:00') {
                return back()->withErrors(['date' => 'Batas waktu pemesanan Tour untuk hari ini (08:00 pagi) sudah lewat. Silakan pilih tanggal besok atau seterusnya.'])->withInput();
            }
        }

        $tour = Tour::findOrFail($id);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'service_name' => $tour->title,
            'service_slug' => $tour->slug,
            'armada_id' => $tour->armada_id,
            'type' => 'tour',
            'amount' => $tour->price * (int) $request->guests,
            'guests' => (int) $request->guests,
            'customer_details' => [
                'names' => $request->participants, 
                'phone' => $request->customer_phone,
                'notes' => $request->notes,
            ],
            'travel_date' => $request->date,
            'pickup_point' => $request->pickup_point,
            'status' => 'unpaid',
        ]);

        return redirect()->route('orders.payment', $booking->id)->with('success', 'Thank you! Please complete your payment for ' . $tour->title);
    }

    public function myOrders()
    {
        $orders = Booking::where('user_id', auth()->id())->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function resetOrders()
    {
        $driver = \DB::getDriverName();
        if ($driver === 'sqlite') {
            \DB::statement('PRAGMA foreign_keys = OFF;');
            Booking::truncate(); // Laravel truncate on sqlite does 'delete from table'
            \DB::table('sqlite_sequence')->where('name', 'bookings')->delete();
            \DB::statement('PRAGMA foreign_keys = ON;');
        } elseif ($driver === 'pgsql') {
            \DB::statement('TRUNCATE TABLE bookings RESTART IDENTITY CASCADE;');
        } else {
            \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Booking::truncate();
            \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
        
        return redirect()->route('orders.my')->with('success', 'Your order history and booking codes have been successfully reset.');
    }

    public function payment($id)
    {
        $order = Booking::where('user_id', auth()->id())->findOrFail($id);
        if (!in_array($order->status, ['unpaid', 'pending'])) {
            return redirect()->route('orders.my');
        }

        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $order->id . '-' . time(),
                'gross_amount' => $order->amount,
            ],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
        } catch (\Exception $e) {
            $snapToken = null;
            // Optionally log the error or return with error
            \Log::error('Midtrans Error: ' . $e->getMessage());
        }

        return view('orders.payment', compact('order', 'snapToken'));
    }

    public function pay(Request $request, $id)
    {
        $request->validate([
            'payment_type' => 'required|string',
            'status' => 'required|string',
        ]);

        $order = Booking::where('user_id', auth()->id())->findOrFail($id);
        
        $data = [
            'payment_method' => $request->payment_type,
            'status' => $request->status, // usually 'paid' from frontend callback
        ];

        $order->update($data);
        
        return redirect()->route('orders.my')->with('success', 'Pembayaran berhasil dikonfirmasi! Pesanan Anda akan segera diproses.');
    }

    public function cancelOrder($id)
    {
        $order = Booking::where('user_id', auth()->id())->findOrFail($id);
        
        if ($order->status !== 'pending') {
            return back()->with('error', 'Only pending orders can be cancelled.');
        }

        $order->update(['status' => 'cancelled']);
        return back()->with('success', 'Booking has been cancelled successfully.');
    }

    public function rescheduleOrder(Request $request, $id)
    {
        $request->validate([
            'new_date' => 'required|date|after:today',
        ]);

        $order = Booking::where('user_id', auth()->id())->findOrFail($id);
        
        if ($order->status === 'cancelled') {
            return back()->with('error', 'Cancelled orders cannot be rescheduled.');
        }

        $order->update([
            'travel_date' => $request->new_date,
            'reschedule_notified' => false,
            'rescheduled_at' => now(),
        ]);
        return back()->with('success', 'Travel date has been updated successfully.');
    }
}