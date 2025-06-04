<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Isi data dasar
        $user->fill($request->validated());

        // Reset verifikasi email jika email diubah
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Upload dan simpan foto profil jika ada
        if ($request->hasFile('profile_photo')) {
            // Hapus file lama jika ada
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            // Simpan file baru
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        // Simpan perubahan ke database
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return back()->with('error', 'Admin tidak bisa dihapus.');
        }

        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        Auth::logout();

        // Hapus file foto profil jika ada
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Tampilkan form biodata untuk mahasiswa/konselor.
     */
    public function showBiodataForm()
    {
        $user = Auth::user();

        if ($user->role === 'mahasiswa') {
            return view('profile.mahasiswa.biodata', compact('user'));
        }

        if ($user->role === 'konselor') {
            return view('profile.konselor.biodata', compact('user'));
        }

        abort(403, 'Unauthorized');
    }

    /**
     * Simpan biodata mahasiswa/konselor.
     */
    public function storeBiodata(Request $request)
    {
        $request->validate([
            'nim' => 'nullable|string|max:255', // nim tidak wajib untuk konselor
            'nip' => 'nullable|string|max:255', // nip tidak wajib untuk mahasiswa
            'jurusan' => 'nullable|string|max:255', // jurusan tidak wajib untuk konselor
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'whatsapp' => 'required|string|max:20',
        ]);

        $user = $request->user();

        $data = [
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'whatsapp' => $request->whatsapp,
        ];

        // Tambahkan data khusus role
        if ($user->role === 'mahasiswa') {
            $data['nim'] = $request->nim;
            $data['jurusan'] = $request->jurusan;
        }

        if ($user->role === 'konselor') {
            $data['nip'] = $request->nip;
        }

        $user->update($data);

        // Redirect sesuai role
        if ($user->role === 'mahasiswa') {
            return redirect()->route('mahasiswa.dashboard')->with('success', 'Biodata berhasil diperbarui.');
        }

        if ($user->role === 'konselor') {
            return redirect()->route('konselor.dashboard')->with('success', 'Biodata berhasil diperbarui.');
        }

        abort(403, 'Unauthorized');
    }
    
    public function deletePhoto(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        if (!$user) {
            abort(403, 'Unauthorized');
        }

        if ($user->profile_photo && Storage::exists('public/' . $user->profile_photo)) {
            Storage::delete('public/' . $user->profile_photo);
        }

        $user->profile_photo = null;
        $user->save();

        return back()->with('status', 'profile-photo-deleted');
    }
}
