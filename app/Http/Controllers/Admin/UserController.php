<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Tampilkan user dengan role mahasiswa dan konselor
        $users = User::whereIn('role', ['mahasiswa', 'konselor'])->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = ['mahasiswa', 'konselor'];
        $jenis_kelamins = ['laki-laki', 'perempuan'];
        
        return view('admin.users.create', compact('roles', 'jenis_kelamins'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:mahasiswa,konselor',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'nip' => 'nullable|string|max:30',
            'nim' => 'nullable|string|max:30',
            'whatsapp' => ['required', 'string', 'regex:/^[0-9]{9,15}$/'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'jenis_kelamin' => $request->jenis_kelamin,
            'nip' => $request->nip,
            'nim' => $request->nim,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dibuat.');
    }

    public function edit(User $user)
    {
        $roles = ['mahasiswa', 'konselor'];
        $jenis_kelamins = ['laki-laki', 'perempuan'];
        return view('admin.users.edit', compact('user', 'roles', 'jenis_kelamins'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:mahasiswa,konselor',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'nip' => 'nullable|string|max:30',
            'nim' => 'nullable|string|max:30',
            'whatsapp' => ['required', 'string', 'regex:/^[0-9]{9,15}$/'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->jenis_kelamin = $request->jenis_kelamin;
        $user ->nip = $request->nip;
        $user ->nim = $request->nim;
        $user->whatsapp = $request->whatsapp;

        if ($request->filled('password')) {
            $request->validate([
                'password' => 'min:6|confirmed',
            ]);
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function ratingsMahasiswa()
{
    $ratings = \App\Models\Rating::with(['booking.mahasiswa', 'booking.jadwal.konselor'])
        ->orderByDesc('created_at')
        ->paginate(15);

    return view('admin.ratings.mahasiswa', compact('ratings'));
}


}
