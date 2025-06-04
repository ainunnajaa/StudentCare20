<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JadwalController extends Controller
{
    /**
     * Tampilkan daftar jadwal.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            // Admin bisa lihat semua jadwal
            $jadwals = Jadwal::with('konselor')->paginate(10);
        } elseif ($user->isKonselor()) {
            // Konselor hanya lihat jadwal miliknya
            $jadwals = Jadwal::where('konselor_id', $user->id)->paginate(10);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('jadwals.index', compact('jadwals'));
    }

    /**
     * Tampilkan form tambah jadwal.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            $konselors = User::where('role', 'konselor')->get();
        } elseif ($user->isKonselor()) {
            $konselors = collect([$user]);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('jadwals.create', compact('konselors'));
    }

    /**
     * Simpan jadwal baru.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'konselor_id' => 'required|exists:users,id',
            'waktu' => 'required|date|after:now',
        ]);

        if ($user->isKonselor() && $request->konselor_id != $user->id) {
            abort(403, 'Unauthorized');
        }

        Jadwal::create([
            'konselor_id' => $request->konselor_id,
            'waktu' => $request->waktu,
            'status' => 'available',
        ]);

        return redirect()->route('jadwals.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Tampilkan form edit jadwal.
     *
     * @param Jadwal $jadwal
     * @return \Illuminate\View\View
     */
    public function edit(Jadwal $jadwal)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isAdmin()) {
            $konselors = User::where('role', 'konselor')->get();
        } elseif ($user->isKonselor() && $jadwal->konselor_id == $user->id) {
            $konselors = collect([$user]);
        } else {
            abort(403, 'Unauthorized');
        }

        return view('jadwals.edit', compact('jadwal', 'konselors'));
    }

    /**
     * Update data jadwal.
     *
     * @param Request $request
     * @param Jadwal $jadwal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        /** @var User $user */
        $user = Auth::user();

        $request->validate([
            'konselor_id' => 'required|exists:users,id',
            'waktu' => 'required|date|after:now',
            'status' => 'required|in:available,booked,done',
        ]);

        if ($user->isKonselor() && $jadwal->konselor_id != $user->id) {
            abort(403, 'Unauthorized');
        }

        $jadwal->update($request->only(['konselor_id', 'waktu', 'status']));

        return redirect()->route('jadwals.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Hapus jadwal.
     *
     * @param Jadwal $jadwal
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Jadwal $jadwal)
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user->isKonselor() && $jadwal->konselor_id != $user->id) {
            abort(403, 'Unauthorized');
        }

        $jadwal->delete();

        return redirect()->route('jadwals.index')->with('success', 'Jadwal berhasil dihapus.');
    }
    
}
