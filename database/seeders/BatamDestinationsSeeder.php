<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tour;
use App\Models\Armada;

class BatamDestinationsSeeder extends Seeder
{
    public function run(): void
    {
        $armada = Armada::first();
        $armadaId = $armada ? $armada->id : null;

        $tours = [
            [
                'title' => 'Batam City Experience',
                'slug' => 'batam-city-highlights',
                'destination' => 'Batam City',
                'price' => 550000,
                'duration' => 'Full Day',
                'image' => 'images/batam_city.jpg',
                'description' => 'Discover the industrial heartbeat and shopping paradise of the Riau Islands. This tour takes you through the most iconic spots in Batam City, including the Welcome to Batam sign, Nagoya Hill, and more.',
                'inclusions' => [
                    ['icon' => 'bus', 'label' => 'VIP Transport'],
                    ['icon' => 'user-check', 'label' => 'Expert Guide'],
                    ['icon' => 'utensils', 'label' => 'Lunch Included'],
                    ['icon' => 'camera', 'label' => 'Documentation'],
                ],
                'armada_id' => $armadaId,
            ],
            [
                'title' => 'Ranoh Island',
                'slug' => 'ranoh-island',
                'destination' => 'Galang Island',
                'price' => 950000,
                'duration' => 'Full Day',
                'image' => 'images/ranoh_island.jpg',
                'description' => 'A tropical paradise with crystal clear water. Enjoy various water sports, relax on the white sandy beach, and experience the beauty of Ranoh Island.',
                'inclusions' => [
                    ['icon' => 'ship', 'label' => 'Speedboat Transfer'],
                    ['icon' => 'waves', 'label' => 'Water Sports'],
                    ['icon' => 'utensils', 'label' => 'Buffet Lunch'],
                    ['icon' => 'umbrella', 'label' => 'Beach Facilities'],
                ],
                'armada_id' => $armadaId,
            ],
            [
                'title' => 'Maha Vihara Duta Maitreya',
                'slug' => 'maha-vihara',
                'destination' => 'Batam Centre',
                'price' => 350000,
                'duration' => '4 Hours',
                'image' => 'images/maha_vihara.jpg',
                'description' => 'Visit one of the largest Buddhist temples in Southeast Asia. Admire the stunning architecture and peaceful atmosphere of Maha Vihara Duta Maitreya.',
                'inclusions' => [
                    ['icon' => 'bus', 'label' => 'Transport'],
                    ['icon' => 'user-check', 'label' => 'Guide'],
                    ['icon' => 'coffee', 'label' => 'Refreshments'],
                ],
                'armada_id' => $armadaId,
            ],
            [
                'title' => 'Barelang Bridge',
                'slug' => 'barelang-bridge',
                'destination' => 'Batam',
                'price' => 450000,
                'duration' => '5 Hours',
                'image' => 'images/barelang_bridge.jpg',
                'description' => 'The iconic landmark of Batam. Barelang Bridge is a chain of 6 bridges that connect the islands of Batam, Rempang, and Galang. Enjoy the breathtaking views of the ocean.',
                'inclusions' => [
                    ['icon' => 'bus', 'label' => 'Transport'],
                    ['icon' => 'camera', 'label' => 'Photo Stop'],
                    ['icon' => 'shopping-bag', 'label' => 'Local Souvenirs'],
                ],
                'armada_id' => $armadaId,
            ],
        ];

        foreach ($tours as $tourData) {
            Tour::updateOrCreate(['slug' => $tourData['slug']], $tourData);
        }
    }
}
