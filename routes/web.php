<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\TransportController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes — PT Nusa Jaya Indofast T&T
|--------------------------------------------------------------------------
*/

// Halaman Utama
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::view('/about', 'about')->name('about');
Route::get('/fix-roles', function() {
    \App\Models\User::whereNull('role')->orWhere('role', '')->update(['role' => 'user']);
    \App\Models\User::where('email', 'hendrazhang@gmail.com')->update([
        'password' => \Illuminate\Support\Facades\Hash::make('12345678')
    ]);
    
    // Fix price for 14 Seat VIP (case insensitive search)
    \Illuminate\Support\Facades\DB::table('armadas')
        ->where('name', '14 Seat VIP')
        ->orWhere('name', '14 SEAT VIP')
        ->update(['price_per_day' => 1200000]);

    $users = \App\Models\User::all(['email', 'role'])->toArray();
    $fleets = \Illuminate\Support\Facades\DB::table('armadas')->select('name', 'price_per_day')->get();
    return response()->json([
        'message' => "Roles fixed, password reset, and 14 SEAT VIP price updated to 1.2M",
        'debug_users' => $users,
        'debug_fleets' => $fleets
    ]);
});

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Tour Routes
Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
Route::get('/orders', [TourController::class, 'myOrders'])->name('orders.my')->middleware('auth');
Route::get('/orders/{id}/payment', [TourController::class, 'payment'])->name('orders.payment')->middleware('auth');
Route::post('/orders/{id}/pay', [TourController::class, 'pay'])->name('orders.pay')->middleware('auth');
Route::post('/orders/reset', [TourController::class, 'resetOrders'])->name('orders.reset')->middleware('auth');
Route::post('/orders/{id}/cancel', [TourController::class, 'cancelOrder'])->name('orders.cancel')->middleware('auth');
Route::post('/orders/{id}/reschedule', [TourController::class, 'rescheduleOrder'])->name('orders.reschedule')->middleware('auth');
Route::get('/tours/{slug}', [TourController::class, 'show'])->name('tours.show');
Route::post('/tours/{id}/book', [TourController::class, 'book'])->name('tours.book')->middleware('auth');

// Transport / Kendaraan
Route::get('/transport', [TransportController::class, 'index'])->name('transport.index');
Route::get('/transport/{slug}', [TransportController::class, 'show'])->name('transport.show');
Route::post('/transport/{id}/book', [TransportController::class, 'book'])->name('transport.book')->middleware('auth');

// Dashboard Route (Admin & Superadmin Only)
Route::middleware(['auth', 'role:admin,superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/bookings', [App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings.index');
    Route::patch('/bookings/{booking}/status', [App\Http\Controllers\Admin\BookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::delete('/bookings/{booking}', [App\Http\Controllers\Admin\BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::resource('armadas', App\Http\Controllers\Admin\ArmadaController::class);
    Route::delete('armadas/{armada}/delete-image', [App\Http\Controllers\Admin\ArmadaController::class, 'deleteImage'])->name('armadas.delete-image');
    Route::delete('armadas/{armada}/delete-main-image', [App\Http\Controllers\Admin\ArmadaController::class, 'deleteMainImage'])->name('armadas.delete-main-image');
    
    Route::resource('tours', App\Http\Controllers\Admin\TourController::class);
    Route::delete('tours/{tour}/delete-image', [App\Http\Controllers\Admin\TourController::class, 'deleteImage'])->name('tours.delete-image');
    Route::delete('tours/{tour}/delete-main-image', [App\Http\Controllers\Admin\TourController::class, 'deleteMainImage'])->name('tours.delete-main-image');

    // User Management (Superadmin Only)
    Route::middleware('role:superadmin')->group(function() {
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
    });

    // Profile & Settings (All Admins)
    Route::get('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/preferences', [App\Http\Controllers\Admin\ProfileController::class, 'preferences'])->name('preferences');
    Route::put('/preferences', [App\Http\Controllers\Admin\ProfileController::class, 'updatePreferences'])->name('preferences.update');
    Route::get('/security', [App\Http\Controllers\Admin\ProfileController::class, 'security'])->name('security');
    Route::put('/security', [App\Http\Controllers\Admin\ProfileController::class, 'updatePassword'])->name('security.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (in_array(auth()->user()->role, ['admin', 'superadmin'])) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('home');
    })->name('dashboard');

    // New User Profile Routes
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/calendar', [UserController::class, 'calendar'])->name('user.calendar');
    Route::get('/preferences', [UserController::class, 'preferences'])->name('user.preferences');
});
