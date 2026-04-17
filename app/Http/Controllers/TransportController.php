<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;

class TransportController extends Controller
{
    private $fleet = [
        1 => [
            'id' => 1,
            'slug' => 'vip-high-deck',
            'name' => '50 Seat VIP High Deck',
            'category' => 'VIP BUS',
            'price' => 1800000,
            'capacity' => '50 Persons',
            'features' => 'VIP Legrest, Air Suspension, Toilet, High Deck (HDD)',
            'description' => 'Armada premium Golden Dragon High Deck (HDD) dengan suspensi udara untuk kenyamanan maksimal. Dilengkapi kursi VIP dengan legrest dan fasilitas kelas atas untuk perjalanan grup eksklusif.',
            'image' => '/images/goldendragon_bus.jpg',
            'available' => true,
            'is_flagship' => true
        ],
        2 => [
            'id' => 2,
            'slug' => 'vip-40-seat',
            'name' => '40 Seat VIP',
            'category' => 'VIP BUS',
            'price' => 1500000,
            'capacity' => '40 Persons',
            'features' => 'VIP Reclining Seats, Full AC, TV/Karaoke, Audio System',
            'description' => 'Armada 40 Seat VIP Golden Dragon yang didesain khusus untuk perjalanan grup kelas menengah dengan kenyamanan premium. Dilengkapi kursi reclining yang lega dan sistem hiburan lengkap untuk perjalanan jauh.',
            'image' => '/images/goldendragon_40seat.jpg',
            'available' => true,
            'is_flagship' => false
        ],
        3 => [
            'id' => 3,
            'slug' => 'medium-bus-premium',
            'name' => 'Medium Bus Premium',
            'category' => 'Medium Bus',
            'price' => 2500000,
            'capacity' => '30 Persons',
            'features' => 'Comfortable Seats, Full AC, Audio System',
            'description' => 'Perfect balance between size and luxury. Ideal for mid-sized groups exploring Batam city landmarks.',
            'image' => 'https://images.unsplash.com/photo-1570125909232-eb263c188f7e?q=80&w=2071&auto=format&fit=crop',
            'available' => true,
            'is_flagship' => false
        ],
        4 => [
            'id' => 4,
            'slug' => 'electric-commuter',
            'name' => 'Electric Commuter Bus',
            'category' => 'Eco Bus',
            'price' => 2800000,
            'capacity' => '20 Persons',
            'features' => 'Eco-Friendly, Silent Engine, USB Ports',
            'description' => 'Go green with our modern electric bus. Silent, comfortable, and sustainable for environmentally conscious groups.',
            'image' => 'https://images.unsplash.com/photo-1570125909232-eb263c188f7e?q=80&w=2071&auto=format&fit=crop',
            'available' => true,
            'is_flagship' => false
        ],
        5 => [
            'id' => 5,
            'slug' => 'mini-bus-executive',
            'name' => 'Mini Bus Executive',
            'category' => 'Mini Bus',
            'price' => 1800000,
            'capacity' => '20 Persons',
            'features' => 'Executive Interior, Full AC, Compact Size',
            'description' => 'Excellent for quick transfers and executive group site visits where agility and comfort are needed.',
            'image' => 'https://images.unsplash.com/photo-1494905998402-395d579af36f?q=80&w=2070&auto=format&fit=crop',
            'available' => true,
            'is_flagship' => false
        ],
        6 => [
            'id' => 6,
            'slug' => 'micro-bus-comfort',
            'name' => 'Micro Bus Comfort',
            'category' => 'Micro Bus',
            'price' => 1200000,
            'capacity' => '15 Persons',
            'features' => 'Standard AC, Comfortable Seats, Efficient',
            'description' => 'An economical choice for smaller groups. Provides reliable transportation for airport transfers and short local trips.',
            'image' => 'https://images.unsplash.com/photo-1532581133564-9ca29e55f65f?q=80&w=2070&auto=format&fit=crop',
            'available' => true,
            'is_flagship' => false
        ],
    ];

    public function index(Request $request)
    {
        $selectedDate = $request->query('date', now()->format('Y-m-d'));
        
        // Process availability
        $bookedSlugs = Booking::where('type', 'transport')
            ->whereDate('travel_date', $selectedDate)
            ->whereIn('status', ['pending', 'paid'])
            ->pluck('service_slug')
            ->toArray();

        $transports = $this->fleet;

        foreach ($transports as &$transport) {
            $transport['available'] = !in_array($transport['slug'], $bookedSlugs);
        }

        return view('transport.index', compact('transports', 'selectedDate'));
    }

    public function show($slug)
    {
        $transport = collect($this->fleet)->firstWhere('slug', $slug);
        
        if (!$transport) abort(404);

        return view('transport.show', compact('transport'));
    }

    public function book(Request $request, $id)
    {
        $request->validate([
            'travel_date' => 'required|date',
        ]);

        $transport = $this->fleet[$id] ?? null;
        if (!$transport) abort(404);

        Booking::create([
            'user_id' => auth()->id(),
            'service_name' => $transport['name'],
            'service_slug' => $transport['slug'],
            'type' => 'transport',
            'amount' => $transport['price'],
            'travel_date' => $request->travel_date,
            'status' => 'pending'
        ]);

        return redirect()->route('orders.my')->with('success', 'Booking transport successful!');
    }
}
