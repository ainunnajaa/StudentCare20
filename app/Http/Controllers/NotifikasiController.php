<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class NotifikasiController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role !== 'konselor') {
            abort(403, 'Unauthorized');
        }

        $pendingBookings = Booking::whereHas('jadwal', function ($query) use ($user) {
            $query->where('konselor_id', $user->id);
        })
        ->where('status', 'pending')
        ->with(['mahasiswa', 'jadwal'])
        ->latest()
        ->get();

        $allBookings = Booking::whereHas('jadwal', function ($query) use ($user) {
            $query->where('konselor_id', $user->id);
        })
        ->with(['mahasiswa', 'jadwal'])
        ->latest()
        ->paginate(10);

        return view('profile.konselor.notifikasi', compact('pendingBookings', 'allBookings', 'user'));
    }
}
