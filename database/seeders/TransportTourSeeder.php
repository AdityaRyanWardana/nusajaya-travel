<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransportTourSeeder extends Seeder
{
    public function run(): void
    {
        // Data Armada (Transport)
        DB::table('armadas')->insert([
            [
                'name' => 'Toyota Hiace Premio',
                'description' => 'Luxury van with 14 seats, perfect for family or group tours.',
                'price_per_day' => 1200000,
                'total_units' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Isuzu ELF Long',
                'description' => 'Spacious van with 19 seats, ideal for large groups.',
                'price_per_day' => 1000000,
                'total_units' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Toyota Avanza',
                'description' => 'Compact MPV for small families, 6-7 seats.',
                'price_per_day' => 500000,
                'total_units' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // Data Tours
        DB::table('tours')->insert([
            [
                'name' => 'City Tour Jakarta Full Day',
                'description' => 'Explore the heart of Indonesia with visits to Monas, Old Town (Kota Tua), and Ancol.',
                'price' => 750000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sentul Nature Trekking',
                'description' => 'A refreshing escape to the waterfalls and hills of Sentul.',
                'price' => 450000,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
