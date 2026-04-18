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
            'price' => 900000,
            'capacity' => '50 Persons',
            'features' => 'VIP Legrest, Air Suspension, Toilet, High Deck (HDD)',
            'description' => 'Flagship Golden Dragon High Deck (HDD) armada dengan suspensi udara untuk keheningan dan kenyamanan maksimal. Dilengkapi kursi VIP dengan legrest dan sistem tata suara premium.',
            'image' => 'https://images.unsplash.com/photo-1544620347-c4fd4a3d5957?q=80&w=2069&auto=format&fit=crop',
            'available' => true,
            'is_flagship' => true
        ],
        2 => [
            'id' => 2,
            'slug' => 'vip-40-seat',
            'name' => '40 Seat VIP Executive',
            'category' => 'VIP BUS',
            'price' => 1500000,
            'capacity' => '40 Persons',
            'features' => 'VIP Reclining Seats, Full AC, TV/Karaoke, Audio System',
            'description' => 'Edisi Executive Golden Dragon dengan konfigurasi kursi 40 seat yang lapang. Sangat cocok untuk perjalanan wisata korporat dengan fasilitas hiburan terlengkap di kelasnya.',
            'image' => 'https://images.unsplash.com/photo-1570125909232-eb263c188f7e?q=80&w=2071&auto=format&fit=crop',
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
            'description' => 'Armada medium yang tangguh dan mewah. Ideal bagi grup berukuran sedang yang ingin menjelajahi sudut-sudut eksotis Batam dengan kemudahan akses jalan sempit sekalipun.',
            'image' => 'https://images.unsplash.com/photo-1562620644-644917a8080c?q=80&w=2070&auto=format&fit=crop',
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
            'description' => 'Simbol modernitas Batam. Bus listrik yang senyap, ramah lingkungan, dan dilengkapi port pengisian daya di setiap kursi. Pilihan tepat bagi rombongan yang peduli lingkungan.',
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
            'description' => 'Mini bus dengan interior kelas eksekutif. Ukuran yang kompak memudahkan akses ke destinasi pantai tersembunyi tanpa mengurangi kemewahan perjalanan Anda.',
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
            'description' => 'Solusi transportasi ekonomis untuk grup kecil. Efisien dan andal untuk antar-jemput bandara atau kunjungan lokasi di seputaran pusat kota Batam.',
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
            'route_option' => 'nullable|string',
            'duration_option' => 'nullable|string'
        ]);

        $transport = $this->fleet[$id] ?? null;
        if (!$transport) abort(404);

        $finalAmount = $transport['price'];
        $routeName = 'Standard Tour';

        if ($request->route_option === 'barelang') {
            $finalAmount = 1800000;
            $routeName = 'PP Barelang';
        } elseif ($request->route_option === 'city_tour') {
            switch ($request->duration_option) {
                case 'one_way':
                    $finalAmount = 900000;
                    $routeName = 'Batam City Tour (One Way)';
                    break;
                case 'half_day':
                    $finalAmount = 1400000;
                    $routeName = 'Batam City Tour (Half Day - 4h)';
                    break;
                case 'one_day':
                    $finalAmount = 1900000;
                    $routeName = 'Batam City Tour (One Day - 8h)';
                    break;
                case 'full_day':
                    $finalAmount = 2200000;
                    $routeName = 'Batam City Tour (Full Day - 12h)';
                    break;
                default:
                    $finalAmount = 900000;
                    $routeName = 'Batam City Tour';
            }
        }

        $booking = Booking::create([
            'user_id' => auth()->id(),
            'service_name' => $transport['name'] . ' - ' . $routeName,
            'service_slug' => $transport['slug'],
            'type' => 'transport',
            'amount' => $finalAmount,
            'travel_date' => $request->travel_date,
            'status' => 'pending'
        ]);

        return redirect()->route('orders.payment', $booking->id)->with('success', 'Booking transport successful! Please complete your payment.');
    }
}
