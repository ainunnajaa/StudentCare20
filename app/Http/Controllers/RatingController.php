<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function create(Booking $booking)
{
    // Cek apakah booking ini punya rating
    if ($booking->rating) {
        return redirect()->back()->with('success', 'Kamu sudah memberi rating.');
    }

    return view('ratings.create', compact('booking'));
}

public function store(Request $request, Booking $booking)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'comment' => 'nullable|string',
    ]);

    Rating::create([
        'booking_id' => $booking->id,
        'rating' => $request->rating,
        'comment' => $request->comment,
    ]);

    return redirect()->route('bookings.index')->with('success', 'Terima kasih atas rating Anda!');
}

    public function showRatingsForKonselor($konselorId)
{
    $konselor = User::where('role', 'konselor')->findOrFail($konselorId);

    $ratings = Rating::with(['booking.jadwal', 'booking.mahasiswa'])
        ->whereHas('booking.jadwal', function ($query) use ($konselorId) {
            $query->where('konselor_id', $konselorId);
        })
        ->orderByDesc('created_at')
        ->get();

    return view('ratings.show', compact('konselor', 'ratings'));
}

public function history()
{
    $user = Auth::user();

    $ratings = Rating::whereHas('booking', function ($query) use ($user) {
        $query->where('mahasiswa_id', $user->id);
    })->with(['booking.jadwal.konselor'])->latest()->get();

    return view('ratings.history', compact('ratings'));
}




}
