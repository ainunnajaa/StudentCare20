<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KonselorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\NotifikasiController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'));
Route::get('/welcome', [AuthController::class, 'welcome'])->name('welcome');

// Custom login/register (jika tidak pakai Laravel Breeze/Sanctum)
Route::get('/login-custom', [AuthController::class, 'showLoginForm'])->name('login.custom');
Route::post('/login-custom', [AuthController::class, 'login']);
Route::get('/register-custom', [AuthController::class, 'showRegisterForm'])->name('register.custom');
Route::post('/register-custom', [AuthController::class, 'register']);

/*
|--------------------------------------------------------------------------
| Route Umum: Dashboard Redirect Berdasarkan Role
// |--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'konselor':
            return redirect()->route('konselor.dashboard');
        case 'mahasiswa':
            return redirect()->route('mahasiswa.dashboard');
        default:
            Auth::logout();
            return redirect()->route('login');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Route Otentikasi + Role Dashboard via AuthController
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/mahasiswa/dashboard', [AuthController::class, 'dashboard'])->name('mahasiswa.dashboard');
    Route::get('/konselor/dashboard', [AuthController::class, 'dashboard'])->name('konselor.dashboard');
    Route::get('/admin/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');
});

/*
|--------------------------------------------------------------------------
| Route Profile (Semua Role)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('/profile/photo', [ProfileController::class, 'deletePhoto'])->name('profile.delete-photo');

});

/*
|--------------------------------------------------------------------------
| Mahasiswa Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/mahasiswa/booking', fn() => 'Halaman Mahasiswa - Booking Jadwal');

    Route::resource('bookings', BookingController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::post('bookings/{id}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
    Route::post('bookings/{id}/done', [BookingController::class, 'markDone'])->name('bookings.markDone');

    Route::get('/profile/mahasiswa/konselor', [KonselorController::class, 'index'])->name('konselor.index');
    
    Route::get('/profile/biodata', [ProfileController::class, 'showBiodataForm'])->name('profile.form');
    Route::post('/profile/biodata', [ProfileController::class, 'storeBiodata'])->name('profile.store');

    Route::get('/ratings/{booking}/create', [RatingController::class, 'create'])->name('ratings.create');
    Route::post('/ratings/{booking}', [RatingController::class, 'store'])->name('ratings.store');

});

/*
|--------------------------------------------------------------------------
| Konselor Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::resource('jadwals', JadwalController::class); // jika jadwal digunakan oleh konselor & admin

    Route::get('/konselor/notifikasi', [NotifikasiController::class, 'index'])->name('konselor.notifikasi');

    Route::get('/konselor/{id}/ratings', [RatingController::class, 'showRatingsForKonselor'])->name('ratings.konselor');
    Route::post('/bookings/{id}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');

});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserController::class);

    // Route::get('profiles', [AdminProfileController::class, 'index'])->name('profiles.index');
    // Route::get('profiles/{user}/edit', [AdminProfileController::class, 'edit'])->name('profiles.edit');
    // Route::put('profiles/{user}', [AdminProfileController::class, 'update'])->name('profiles.update');
    Route::get('/ratings-mahasiswa', [UserController::class, 'ratingsMahasiswa'])->name('ratings.mahasiswa');
    // Jika admin juga kelola jadwal
    Route::resource('jadwals', JadwalController::class);
});

Route::get('/ratings/history', [RatingController::class, 'history'])
    ->middleware('auth') // agar hanya user yang login yang bisa akses
    ->name('ratings.history');

require __DIR__.'/auth.php';
