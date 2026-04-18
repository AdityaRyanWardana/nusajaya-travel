<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class TourController extends Controller
{
    private $destinations = [
        'batam-city-tour' => [
            'name' => 'Classic Batam City Tour',
            'slug' => 'batam-city-tour',
            'price' => 350000,
            'image' => 'https://images.unsplash.com/photo-1542259009477-d625272157b7?q=80&w=2069&auto=format&fit=crop',
            'description' => 'A comprehensive journey through Batam\'s landmarks, shopping centers, and culinary hotspots. Perfect for first-timers.',
            'category' => 'Batam City Tour',
        ],
        'pantai-viovio' => [
            'name' => 'Pantai Viovio Sunset',
            'slug' => 'pantai-viovio',
            'price' => 550000,
            'image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2070&auto=format&fit=crop',
            'description' => 'Experience the most beautiful sunset in Batam. Known for its iconic swings and crystal clear shallow water.',
            'category' => 'PP Barelang',
        ],
        'ranoh-island' => [
            'name' => 'Ranoh Island Premium',
            'slug' => 'ranoh-island',
            'price' => 750000,
            'image' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?q=80&w=2070&auto=format&fit=crop',
            'description' => 'Escape to a secluded island with premium facilities. Includes snorkeling, kayaking, and an all-day buffet.',
            'category' => 'Island Tour',
        ],
        'barelang-bridge' => [
            'name' => 'Barelang Architectural Tour',
            'slug' => 'barelang-bridge',
            'price' => 550000,
            'image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2070&auto=format&fit=crop',
            'description' => 'A dedicated tour to the 6 bridges of Barelang, showcasing the engineering marvel that connects Batam islands.',
            'category' => 'PP Barelang',
        ],
        'maha-vihara' => [
            'name' => 'Maha Vihara Spiritual',
            'slug' => 'maha-vihara',
            'price' => 400000,
            'image' => '/images/maha_vihara.png',
            'description' => 'Visit the largest Buddhist temple in Southeast Asia. A place of peace, stunning architecture, and spiritual reflection.',
            'category' => 'Batam City Tour',
        ],
        'galang-refugee' => [
            'name' => 'Galang Refugee Camp History',
            'slug' => 'galang-refugee',
            'price' => 600000,
            'image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2070&auto=format&fit=crop',
            'description' => 'Explore the poignant history of Vietnamese refugees in the late 70s. A deeply moving historical site in Galang Island.',
            'category' => 'PP Barelang',
        ],
    ];

    public function index(Request $request)
    {
        $category = $request->query('category');
        $tours = $this->destinations;

        if ($category && $category !== 'All') {
            $tours = array_filter($this->destinations, function($tour) use ($category) {
                return $tour['category'] === $category;
            });
        }

        return view('tours.index', [
            'tours' => $tours,
            'selectedCategory' => $category ?: 'All'
        ]);
    }

    public function show($slug)
    {
        if (!isset($this->destinations[$slug])) {
            abort(404);
        }
        return view('tours.show', ['tour' => $this->destinations[$slug]]);
    }

    public function book(Request $request, $slug)
    {
        if (!isset($this->destinations[$slug])) {
            abort(404);
        }

        $tour = $this->destinations[$slug];

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'service_name' => $tour['name'],
            'service_slug' => $slug,
            'type' => 'tour',
            'amount' => $tour['price'],
            'guests' => (int) $request->guests,
            'travel_date' => $request->date,
            'status' => 'pending',
        ]);

        return redirect()->route('orders.payment', $booking->id)->with('success', 'Thank you! Please complete your payment for ' . $tour['name']);
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