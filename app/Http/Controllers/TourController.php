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
        $tour = Tour::findOrFail($id);

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'service_name' => $tour->title,
            'service_slug' => $tour->slug,
            'armada_id' => $tour->armada_id,
            'type' => 'tour',
            'amount' => $tour->price,
            'guests' => (int) $request->guests,
            'travel_date' => $request->date,
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
        // Truncate table and reset sequence for SQLite
        if (\DB::getDriverName() === 'sqlite') {
            \DB::statement('PRAGMA foreign_keys = OFF;');
            Booking::truncate(); // Laravel truncate on sqlite does 'delete from table'
            \DB::table('sqlite_sequence')->where('name', 'bookings')->delete();
            \DB::statement('PRAGMA foreign_keys = ON;');
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
        return view('orders.payment', compact('order'));
    }

    public function pay(Request $request, $id)
    {
        $request->validate([
            'payment_type' => 'required|string',
            'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:3072',
        ]);

        $order = Booking::where('user_id', auth()->id())->findOrFail($id);
        
        $data = [
            'payment_method' => $request->payment_type,
            'status' => 'pending', // Status menjadi 'pending' (menunggu verifikasi) setelah upload
        ];

        if ($request->hasFile('payment_proof')) {
            $data['payment_proof'] = $request->file('payment_proof')->store('payments', 'public');
        }

        $order->update($data);
        
        return redirect()->route('orders.my')->with('success', 'Bukti pembayaran berhasil diunggah! Pesanan Anda akan segera diproses.');
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

        $order->update(['travel_date' => $request->new_date]);
        return back()->with('success', 'Travel date has been updated successfully.');
    }
}