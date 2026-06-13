<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            
            // Cari user berdasarkan google_id atau email
            $user = User::where('google_id', $googleUser->getId())
                        ->orWhere('email', $googleUser->getEmail())
                        ->first();

            if ($user) {
                // Update google_id jika login dengan email yang sama tapi belum punya google_id
                if (!$user->google_id) {
                    $user->update(['google_id' => $googleUser->getId()]);
                }
                
                Auth::login($user);
                
                if (in_array($user->role, ['admin', 'superadmin'])) {
                    return redirect()->route('admin.dashboard');
                }
                
                return redirect()->route('home')->with('success', 'Berhasil masuk dengan Google!');
            } else {
                // Buat user baru
                $newUser = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => null, // Password null karena login via Google
                    'role' => 'user',
                    'phone' => '-', // Default karena Google tidak selalu memberikan nomor HP
                ]);
                
                Auth::login($newUser);
                return redirect()->route('user.profile')->with('success', 'Registrasi dengan Google berhasil! Silakan lengkapi profil dan nomor telepon Anda.');
            }
        } catch (\Exception $e) {
            \Log::error('Google Socialite Error: ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('login')->with('error', 'Gagal masuk menggunakan Google. Silakan coba lagi.');
        }
    }
}
