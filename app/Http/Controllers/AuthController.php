<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rating;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   public function register(Request $request)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'confirmed', 'min:8'],
        // tambahkan validasi role jika diperlukan
    ]);

    $user = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => bcrypt($validated['password']),
        'role' => 'mahasiswa', // atau sesuai input jika ada
    ]);

    // Kirim email verifikasi otomatis
    $user->sendEmailVerificationNotification();

    // Jangan login otomatis!
    // Redirect ke halaman notifikasi verifikasi email
    return redirect()->route('verification.notice')->with('message', 'Silakan cek email Anda dan klik tautan verifikasi.');
}

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function welcome()
    {
        return view('welcome');
    }

    public function dashboard()
    {
        $user = Auth::user();

        switch ($user->role) {
            case 'mahasiswa':
                $bookings = Booking::with('jadwal.konselor')
                    ->where('mahasiswa_id', $user->id)
                    ->join('jadwals', 'bookings.jadwal_id', '=', 'jadwals.id')
                    ->orderBy('jadwals.waktu', 'desc')
                    ->select('bookings.*')
                    ->paginate(10);

                $totalBooking = Booking::where('mahasiswa_id', $user->id)->count();

                $totalSelesai = Booking::where('mahasiswa_id', $user->id)
                    ->whereHas('jadwal', fn ($query) => $query->where('status', 'selesai'))
                    ->count();

                $jumlahKonselor = User::where('role', 'konselor')->count();

                return view('mahasiswa.dashboard', compact(
                    'bookings', 'user', 'totalBooking', 'totalSelesai', 'jumlahKonselor'
                ));

            case 'konselor':
                $pendingBookings = Booking::with(['mahasiswa', 'jadwal'])
                    ->whereHas('jadwal', function ($query) use ($user) {
                        $query->where('konselor_id', $user->id);
                    })
                    ->where('status', 'pending')
                    ->get();

                $totalSelesai = Booking::whereHas('jadwal', function ($query) use ($user) {
                        $query->where('konselor_id', $user->id);
                    })
                    ->where('status', 'selesai')
                    ->count();

                $jumlahMahasiswa = Booking::whereHas('jadwal', function ($query) use ($user) {
                        $query->where('konselor_id', $user->id);
                    })
                    ->distinct('mahasiswa_id')
                    ->count('mahasiswa_id');
                
                    $rataRataRating = Rating::whereHas('booking.jadwal', function ($query) use ($user) {
                        $query->where('konselor_id', $user->id);
                    })->avg('rating');


                return view('konselor.dashboard', compact(
                    'user',
                    'pendingBookings',
                    'totalSelesai',
                    'jumlahMahasiswa',
                    'rataRataRating'
                ));


            case 'admin':
                $totalUsers = User::count();
                $totalMahasiswa = User::where('role', 'mahasiswa')->count();
                $totalKonselor = User::where('role', 'konselor')->count();

                return view('admin.dashboard', compact(
                    'user',
                    'totalUsers',
                    'totalMahasiswa',
                    'totalKonselor'
            ));

            default:
                Auth::logout();
                return redirect()->route('login')->withErrors([
                    'email' => 'Role tidak dikenali.',
                ]);
        }
    }
}
