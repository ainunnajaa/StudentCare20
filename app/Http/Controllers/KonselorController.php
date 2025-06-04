<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class KonselorController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $konselors = User::where('role', 'konselor')
        ->when($search, function ($query, $search) {
            $query->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%")
                  ->orWhere('nip', 'like', "%$search%");
        })
        ->select('users.*')
        ->selectSub(function($query) {
            $query->from('ratings')
                ->join('bookings', 'ratings.booking_id', '=', 'bookings.id')
                ->join('jadwals', 'bookings.jadwal_id', '=', 'jadwals.id')
                ->whereColumn('jadwals.konselor_id', 'users.id')
                ->selectRaw('avg(ratings.rating)');
        }, 'ratings_avg_rating')
        ->get();

    return view('profile.mahasiswa.konselor', compact('konselors'));
}



}
