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
        $orders = Booking::where('user_id', auth()->id())
            ->where('is_hidden_from_user', false)
            ->latest()
            ->get();
        return view('orders.index', compact('orders'));
    }

    public function resetOrders()
    {
        $userId = auth()->id();

        // 1. Hard delete unpaid and cancelled bookings to save space
        Booking::where('user_id', $userId)
            ->whereIn('status', ['unpaid', 'cancelled'])
            ->delete();

        // 2. Hide paid and pending bookings to keep admin records and revenue intact
        Booking::where('user_id', $userId)
            ->whereNotIn('status', ['unpaid', 'cancelled'])
            ->update(['is_hidden_from_user' => true]);
        
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
            'midtrans_order_id' => 'required|string',
        ]);

        $order = Booking::where('user_id', auth()->id())->findOrFail($id);
        
        // Verifikasi langsung ke Midtrans API (Bypass Webhook InfinityFree)
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');

        try {
            $status = \Midtrans\Transaction::status($request->midtrans_order_id);
            
            if ($status->transaction_status == 'settlement' || $status->transaction_status == 'capture') {
                $order->update([
                    'payment_method' => $request->payment_type,
                    'status' => 'paid',
                ]);
                return redirect()->route('orders.my')->with('success', 'Pembayaran berhasil dikonfirmasi! Pesanan Anda akan segera diproses.');
            } else {
                return redirect()->route('orders.my')->with('error', 'Status pembayaran belum lunas di sistem Midtrans (Status: ' . $status->transaction_status . ').');
            }
        } catch (\Exception $e) {
            \Log::error('Midtrans Status Check Error: ' . $e->getMessage());
            return redirect()->route('orders.my')->with('error', 'Gagal memverifikasi pembayaran dengan Midtrans. Silakan hubungi admin.');
        }
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

    /**
     * Check the current payment status of an order (used for AJAX polling).
     */
    public function checkStatus($id)
    {
        $order = Booking::where('user_id', auth()->id())->findOrFail($id);
        return response()->json([
            'status' => $order->status,
            'order_id' => $order->id,
        ]);
    }
}