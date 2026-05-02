<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Super Admin
        User::updateOrCreate(['email' => 'superadmin@nusajaya.com'], [
            'name'     => 'Super Admin',
            'password' => bcrypt('password123'),
            'role'     => 'superadmin',
        ]);

        // Admin
        User::updateOrCreate(['email' => 'admin@nusajaya.com'], [
            'name'     => 'Admin Utama',
            'password' => bcrypt('password123'),
            'role'     => 'admin',
        ]);

        // Regular User
        User::updateOrCreate(['email' => 'user@nusajaya.com'], [
            'name'     => 'Regular User',
            'password' => bcrypt('password123'),
            'role'     => 'user',
        ]);

        // Transport & Tours
        $this->call(TransportTourSeeder::class);
    }
}
