<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TransportController;

/*
|--------------------------------------------------------------------------
| Web Routes — PT Nusa Jaya Indofast T&T
|--------------------------------------------------------------------------
*/

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Tour Routes
Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/orders', [TourController::class, 'myOrders'])->name('orders.my')->middleware('auth');
Route::post('/orders/{id}/cancel', [TourController::class, 'cancelOrder'])->name('orders.cancel')->middleware('auth');
Route::post('/orders/{id}/reschedule', [TourController::class, 'rescheduleOrder'])->name('orders.reschedule')->middleware('auth');
Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours.show');
Route::post('/tours/{id}/book', [TourController::class, 'book'])->name('tours.book')->middleware('auth');

// Transport / Kendaraan
Route::get('/transport', [TransportController::class, 'index'])->name('transport.index');
Route::get('/transport/{slug}', [TransportController::class, 'show'])->name('transport.show');
Route::post('/transport/{id}/book', [TransportController::class, 'book'])->name('transport.book')->middleware('auth');

// Dashboard Route (Admin Only)
Route::get('/dashboard', function () {
    if (auth()->check() && auth()->user()->role === 'admin') {
        return view('dashboard');
    }
    return redirect()->route('home');
})->name('dashboard')->middleware('auth');
