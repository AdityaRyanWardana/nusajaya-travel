<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class TourController extends Controller
{
    private $destinations = [
        'batam-city-tour' => [
            'name' => 'Batam City Tour',
            'slug' => 'batam-city-tour',
            'price' => 350000,
            'image' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?q=80&w=2070&auto=format&fit=crop',
            'description' => 'A comprehensive journey through Batam\'s landmarks, shopping centers, and culinary hotspots.',
            'category' => 'Batam City Tour',
        ],
        'pantai-melur' => [
            'name' => 'Pantai Melur Excursion',
            'slug' => 'pantai-melur',
            'price' => 450000,
            'image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2070&auto=format&fit=crop',
            'description' => 'Visit one of Batam\'s most legendary beaches with calm waters and white sand.',
            'category' => 'PP Barelang',
        ],
        'pantai-mirota' => [
            'name' => 'Pantai Mirota Beach Day',
            'slug' => 'pantai-mirota',
            'price' => 500000,
            'image' => 'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?q=80&w=2070&auto=format&fit=crop',
            'description' => 'A beautiful clean beach at Galang Island, perfect for family picnics and water sports.',
            'category' => 'PP Barelang',
        ],
        'pantai-viovio' => [
            'name' => 'Pantai Viovio Sunset',
            'slug' => 'pantai-viovio',
            'price' => 550000,
            'image' => 'https://images.unsplash.com/photo-1544644181-1484b3fdfc62?q=80&w=2070&auto=format&fit=crop',
            'description' => 'Known for its stunning sunset views and iconic swings in the shallow water.',
            'category' => 'PP Barelang',
        ],
        'nagoya-hill' => [
            'name' => 'Nagoya Hill Shopping',
            'slug' => 'nagoya-hill',
            'price' => 300000,
            'image' => 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?q=80&w=2070&auto=format&fit=crop',
            'description' => 'Experience the best shopping experience in Batam at Nagoya Hill Mall. Find original products and local delicacies.',
            'category' => 'Batam City Tour',
        ],
        'maha-vihara' => [
            'name' => 'Maha Vihara Temple',
            'slug' => 'maha-vihara',
            'price' => 400000,
            'image' => 'https://images.unsplash.com/photo-1604104445831-2fb98f98ec4e?q=80&w=2070&auto=format&fit=crop',
            'description' => 'Experience peace at the largest Buddhist temple in Southeast Asia, known for its Maitreya statues.',
            'category' => 'Batam City Tour',
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

        Booking::create([
            'user_id' => auth()->id(),
            'service_name' => $tour['name'],
            'service_slug' => $slug,
            'type' => 'tour',
            'amount' => $tour['price'],
            'guests' => (int) $request->guests,
            'travel_date' => $request->date,
            'status' => 'pending',
        ]);

        return redirect()->route('orders.my')->with('success', 'Thank you! Your booking for ' . $tour['name'] . ' has been received. Please complete the payment.');
    }

    public function myOrders()
    {
        $orders = Booking::where('user_id', auth()->id())->latest()->get();
        return view('orders.index', compact('orders'));
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