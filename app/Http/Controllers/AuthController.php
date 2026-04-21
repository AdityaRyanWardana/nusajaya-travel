<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
class AuthController extends Controller
{
    /**
     * Tampilkan halaman Login & Registrasi (Tab: Login)
     */
    public function showLogin()
    {
        if (Auth::check()) {
            if (in_array(Auth::user()->role, ['admin', 'superadmin'])) {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('home');
        }
        return view('auth.login');
    }

    /**
     * Proses Login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->has('remember'))) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            if (in_array($user->role, ['admin', 'superadmin'])) {
                return redirect()->intended(route('admin.dashboard'));
            }
            return redirect()->route('home');
        }

        return back()->with('error', 'Kredensial tidak valid. Silakan periksa kembali email atau kata sandi Anda.')->withInput();
    }

    /**
     * Tampilkan halaman Registrasi (Tab: Register)
     */
    public function showRegister()
    {
        return view('auth.register');
    }

    /**
     * Proses Registrasi
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'phone'    => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => 'user', // Set default role
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registrasi berhasil! Selamat datang di Nusajaya Travel.');
    }

    /**
     * Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
