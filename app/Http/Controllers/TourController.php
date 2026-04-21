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
            'type' => 'tour',
            'amount' => $tour->price,
            'guests' => (int) $request->guests,
            'travel_date' => $request->date,
            'status' => 'pending',
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
        if ($order->status !== 'pending') {
            return redirect()->route('orders.my');
        }
        return view('orders.payment', compact('order'));
    }

    public function pay(Request $request, $id)
    {
        $order = Booking::where('user_id', auth()->id())->findOrFail($id);
        
        // Simulation of processing payment
        $order->update(['status' => 'paid']);
        
        return redirect()->route('orders.my')->with('success', 'Payment successful! Your booking is now confirmed.');
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