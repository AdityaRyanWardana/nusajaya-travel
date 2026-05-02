<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Promotion;

class HomeController extends Controller
{
    /**
     * Tampilkan halaman utama (Homepage - English Edition)
     */
    public function index()
    {
        $promotions = Promotion::where('is_active', true)
            ->where(function($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->latest()
            ->get();

        $main_promotion = $promotions->first();
        $grid_promotions = $promotions->skip(1)->take(3);
        
        // If no promotions in DB, we'll keep the defaults in blade or handle it there.
        $destinations = [
            [
                'name' => 'Batam',
                'label' => 'Gate to Riau Islands',
                'description' => 'Center for industry, shopping, and the main international tourism gateway to the Riau Islands.',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAGYd10roPjOp6tDZm4kXa_tdf02b1ReHZxcb5BX3sX3oK7mnYRxDRipsD4ZsUVvyMuJmv0A87c-_s2a1nWWthQEH5atVwdfmaExAqVdAkpRIeYFfdRm-6FSy19UJPGXKF4sYClsUk6EIO1GYROAqr07aBm-_D35GHs3n2GKenAck12jx7CYAVF2Ndz6kEJ0sL1Ww3NK6P_ehLgR7x_uIdS-avUGbXEdsZGUbrtlhhUl-Z55sI8P3P-OHpF9BE1Geu-tK937EHw8YNT',
                'span' => 'col-span-2 row-span-2',
                'size' => 'large',
            ],
            [
                'name' => 'Bintan',
                'description' => 'World-class resorts and exotic white sand beaches.',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAKMQlc7_MNNMbUn90Q1wfc0HwLHnUw8OcuoNtU7kgdQevY08WlmqJToWwc722XVUye931m6_jDBCd64OaOYKd_JQl5jpCGgkA1kjlHm5Q-iXoV7m4omGbTE7XqaDkZMOKSjp6mqL32tkjOJYqZRf31sHOZmFF1vf0qZhDZWS9h1xf3F8mVCpEIjeluy_vO1mpPpID0W8lO3BIie_GpWUl0EKTcKP6nOPGK438twhrreaGkpEyOSlgXIzIKEhaMNJDEunNvpaZVbezx',
                'span' => 'col-span-2 row-span-1',
                'size' => 'medium',
            ],
            [
                'name' => 'Bali',
                'description' => 'Island of the Gods with stunning temples and beaches.',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuCGWSOqCEnUoNqoHuD6IzvdGMVRvSIGhYBpRJRd124vGxsomxJaOFo6d5OU2TSy83Zpdgauya12KrE_4eiRTFELHm-lvqJOLdFOqYJFfaNaf8IpqHa27wjg-9BFH6I9ISWBabMy1nc6FUCD1R3dujxU55S4It2Ibgls1KkFMs4u4xyBVr-DfBy8LI3hxvbiK2q_7RT7E6iX9v5vBHYZ6jWUJvTvHaGup4zAz6NNpiFLnXCxN9GkeEjwbahSVTxOi8AbdaeO8Y7FJQBC',
                'span' => 'col-span-1 row-span-1',
                'size' => 'small',
            ],
            [
                'name' => 'Jakarta',
                'description' => 'Indonesia\'s vibrant capital city.',
                'image' => 'https://lh3.googleusercontent.com/aida-public/AB6AXuAH2EDtAv-BZyw2KsPO9HELA0C52yVlWlyR2lmCKXlZhaJgsc7hX9ja_feO7xKlcRg1DJcF-C3HLo64YJFKumCveLrlDC9nZe93dPpnxD6Vu1duP0lxrjJnFvNSteB-BnWebSYA7jrOcU0h6BSZOoV9iq6Vn2ZrMO4cdWoVSGyX-_pKSmpmwJGHP0wB7RghTmi_Y4qG1UfsrxbsNJmnKrkQFNLF_9mSVCcqtFmgCsFGn7LyaEGIg-GiSO7ZOFpfQzLWS_VLfo-35GGV',
                'span' => 'col-span-1 row-span-1',
                'size' => 'small',
            ],
        ];

        $services = [
            [
                'icon' => 'airport_shuttle',
                'title' => 'Transport Booking',
                'description' => 'Airport and seaport pickup service with the latest fleet that is clean and comfortable.',
                'link' => route('transport.index'),
                'link_text' => 'Learn More',
                'featured' => false,
            ],
            [
                'icon' => 'tour',
                'title' => 'Tour Packages',
                'description' => 'Exploration of exciting destinations in Batam & Bintan with integrated tour packages that are economical and fun.',
                'link' => route('tours.index'),
                'link_text' => 'View Tour Packages',
                'featured' => true,
            ],
            [
                'icon' => 'directions_car',
                'title' => 'Private Car',
                'description' => 'Daily car rental with professional drivers for your business needs or family holidays.',
                'link' => route('transport.index'),
                'link_text' => 'Check Fleet',
                'featured' => false,
            ],
        ];

        return view('welcome', compact('destinations', 'services', 'main_promotion', 'grid_promotions'));
    }
}
