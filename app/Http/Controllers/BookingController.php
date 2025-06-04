<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Tampilkan daftar booking milik mahasiswa yang login.
     */
    public function index()
{
    $user = Auth::user();

    if ($user && $user->role === 'mahasiswa') {
        $now = now();

        // 1. Update booking booked yang sudah lewat sesi jadi done
        $bookingsToUpdateDone = Booking::with('jadwal')
            ->where('mahasiswa_id', $user->id)
            ->where('status', 'booked')
            ->get();

        foreach ($bookingsToUpdateDone as $booking) {
            $waktuMulai = $booking->jadwal->waktu;
            $waktuSelesai = \Carbon\Carbon::parse($waktuMulai)->addMinutes(60);

            if ($now->greaterThanOrEqualTo($waktuSelesai)) {
                $booking->update(['status' => 'done']);
                $booking->jadwal->update(['status' => 'available']);
            }
        }

        // 2. Update booking pending yang sudah lewat jadwal jadi not_confirmed
        $bookingsToUpdateNotConfirmed = Booking::with('jadwal')
            ->where('mahasiswa_id', $user->id)
            ->where('status', 'pending')
            ->get();

        foreach ($bookingsToUpdateNotConfirmed as $booking) {
            $waktuMulai = $booking->jadwal->waktu;

            if ($now->greaterThanOrEqualTo($waktuMulai)) {
                $booking->update(['status' => 'not_confirmed']);
                $booking->jadwal->update(['status' => 'available']);
            }
        }

        // Ambil booking dengan relasi konselor untuk ditampilkan
        $bookings = Booking::with('jadwal.konselor')
            ->where('mahasiswa_id', $user->id)
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
    }

    abort(403, 'Unauthorized');
}


    /**
     * Tampilkan form untuk booking jadwal.
     */
    public function create()
    {
        $user = Auth::user();

        if ($user && $user->role === 'mahasiswa') {
            $jadwals = Jadwal::where('status', 'available')
                ->where('waktu', '>', now())
                ->paginate(10);

            return view('bookings.create', compact('jadwals'));
        }

        abort(403, 'Unauthorized');
    }

    /**
     * Simpan booking baru.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'mahasiswa') {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
        ]);

        $jadwal = Jadwal::findOrFail($request->jadwal_id);

        if ($jadwal->status !== 'available') {
            return back()->withErrors(['jadwal_id' => 'Jadwal sudah tidak tersedia']);
        }

        if ($jadwal->waktu <= now()) {
            return back()->withErrors(['jadwal_id' => 'Jadwal sudah lewat waktu']);
        }

        Booking::create([
            'jadwal_id' => $jadwal->id,
            'mahasiswa_id' => $user->id,
            'status' => 'pending',
        ]);

        $jadwal->update(['status' => 'booked']);
        

        return redirect()->route('bookings.index')->with('success', 'Booking berhasil dibuat');
    }

    /**
     * Hapus booking (oleh mahasiswa).
     */public function destroy(Booking $booking)
{
    $user = Auth::user();

    if (!$user) {
        abort(403, 'Unauthorized');
    }

    // Kembalikan status jadwal jika ada
    if ($booking->jadwal) {
        $booking->jadwal->update(['status' => 'available']);
    }

    $booking->delete();

    return redirect()->route('bookings.index')->with('success', 'Booking berhasil dihapus.');
}


    /**
     * Konfirmasi booking oleh konselor.
     */
    public function confirm($id)
{
    $user = Auth::user();

    if (!$user) {
        abort(403, 'Unauthorized');
    }

    $booking = Booking::with('jadwal')->findOrFail($id);

    // Jika kamu masih ingin cek kepemilikan, sesuaikan atau hilangkan ini:
    // Misal hapus jika semua boleh akses tanpa batasan:
    // if ($booking->jadwal->konselor_id !== $user->id) {
    //     abort(403, 'Unauthorized');
    // }

    $now = now();
    $waktuMulai = $booking->jadwal->waktu;
    $waktuSelesai = \Carbon\Carbon::parse($waktuMulai)->addMinutes(60); // durasi 60 menit

    if ($now->greaterThanOrEqualTo($waktuSelesai)) {
        return back()->withErrors(['error' => 'Waktu sesi sudah lewat, tidak bisa konfirmasi.']);
    }

    $booking->update(['status' => 'booked']);
    $booking->jadwal->update(['status' => 'booked']);

    return back()->with('success', 'Booking berhasil dikonfirmasi.');
}

    /**
     * Tandai booking selesai oleh konselor.
     */
    public function markDone($id)
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'konselor') {
            abort(403);
        }

        $booking = Booking::with('jadwal')->findOrFail($id);

        if ($booking->jadwal->konselor_id !== $user->id) {
            abort(403);
        }

        $booking->update(['status' => 'done']);
        $booking->jadwal->update(['status' => 'available']);

        return back()->with('success', 'Booking berhasil ditandai selesai.');
    }
}