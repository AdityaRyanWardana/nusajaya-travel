<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransportTourSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('armadas')->insert([
            [
                'name' => 'Toyota Hiace Premio',
                'slug' => 'toyota-hiace-premio',
                'type' => 'Van',
                'capacity' => 14,
                'price_per_day' => 1200000,
                'image' => 'armadas/41VKLo95gjj3LDp1yYmOlOvlBVuQXCYt7eIsW1JY.jpg',
                'description' => 'Luxury van with 14 seats, perfect for family or group tours in Batam.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Isuzu ELF Long',
                'slug' => 'isuzu-elf-long',
                'type' => 'Minibus',
                'capacity' => 19,
                'price_per_day' => 1000000,
                'image' => 'armadas/OgUlXTUL2CVXE9RTEXGKbuyhsKEXNeYE8DwChJlj.jpg',
                'description' => 'Spacious minibus with 19 seats, ideal for large groups.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Toyota Avanza',
                'slug' => 'toyota-avanza',
                'type' => 'MPV',
                'capacity' => 7,
                'price_per_day' => 500000,
                'image' => 'armadas/V929aFO2CH8jLdlei6wgKwNDD2bPVIhglAVG1ErI.jpg',
                'description' => 'Compact MPV for small families, 6-7 seats.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Toyota Innova Reborn',
                'slug' => 'toyota-innova-reborn',
                'type' => 'MPV',
                'capacity' => 7,
                'price_per_day' => 800000,
                'image' => 'armadas/Xyv7rwiEn3gqo7WQ1rd6rE8XpLVKVD14CQLcLtwg.jpg',
                'description' => 'Premium MPV for executive trips and family comfort.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        DB::table('tours')->insert([
            [
                'title' => 'Ranoh Island One Day Tour',
                'slug' => 'ranoh-island-one-day-tour',
                'destination' => 'Pulau Ranoh, Batam',
                'price' => 850000,
                'duration' => '1 Day',
                'image' => 'tours/ranoh.png',
                'description' => 'Experience the pristine beaches and thrilling water sports at Ranoh Island.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Batam Authentic Culinary Tour',
                'slug' => 'batam-authentic-culinary-tour',
                'destination' => 'Batam City',
                'price' => 450000,
                'duration' => '1 Day',
                'image' => 'tours/culinary.png',
                'description' => 'Taste the best seafood and local delicacies Batam has to offer.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Batam City Exploration',
                'slug' => 'batam-city-exploration',
                'destination' => 'Barelang Bridge & Nagoya',
                'price' => 550000,
                'duration' => '1 Day',
                'image' => 'tours/PYPO4gMarARIsYTVrHrbG8hdtwzBX4h5aXC11tmG.jpg',
                'description' => 'Visit the iconic Barelang Bridge, Welcome to Batam monument, and enjoy duty-free shopping at Nagoya.',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
