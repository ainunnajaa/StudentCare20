@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold text-black">Edit User</h1>

    <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- ... field lainnya ... --}}
        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
            <select id="jenis_kelamin" name="jenis_kelamin" class="form-select" onchange="handleRoleChange()">
                <option value="" selected disabled>Pilih jenis kelamin</option>
                @foreach ($jenis_kelamins as $jenis_kelamin)
                    <option value="{{ $jenis_kelamin }}" 
                        {{ old('jenis_kelamin', isset($user) ? $user->jenis_kelamin : '') == $jenis_kelamin ? 'selected' : '' }}>
                        {{ ucfirst($jenis_kelamin) }}
                    </option>
                @endforeach
            </select>
            @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
        </div>



        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select id="role" name="role" class="form-select" required onchange="handleRoleChange()">
                @foreach ($roles as $role)
                    <option value="{{ $role }}" {{ old('role', $user->role) == $role ? 'selected' : '' }}>
                        {{ ucfirst($role) }}
                    </option>
                @endforeach
            </select>
            @error('role') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Nomor WhatsApp --}}
        <div class="mb-3">
            <label for="whatsapp" class="form-label">Nomor WhatsApp (contoh: 6281234567890)</label>
            <input id="whatsapp" name="whatsapp" type="text" value="{{ old('whatsapp', $user->whatsapp) }}" class="form-control" placeholder="Masukkan nomor WA tanpa + dan spasi">
            @error('whatsapp') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- NIP hanya untuk konselor --}}
        <div class="mb-3" id="nip-field">
            <label for="nip" class="form-label">Nomor Induk Pegawai (contoh: 19840326 202301 2 008)</label>
            <input id="nip" name="nip" type="text" value="{{ old('nip', $user->nip) }}" class="form-control" placeholder="Masukkan Nomor NIP">
            @error('nip') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- NIM hanya untuk mahasiswa --}}
        <div class="mb-3" id="nim-field">
            <label for="nim" class="form-label">Nomor Induk Mahasiswa (contoh: 2305090006)</label>
            <input id="nim" name="nim" type="text" value="{{ old('nim', $user->nim) }}" class="form-control" placeholder="Masukkan Nomor NIM">
            @error('nim') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label for="password" class="form-label">Password (isi jika ingin ganti)</label>
            <input id="password" name="password" type="password" class="form-control" autocomplete="new-password">
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
<style>
    h1, .h1 {
  font-size: calc(1.375rem + 1.5vw);
  margin-top: 0;
  margin-bottom: .5rem;
  line-height: 1.2;
}

.text-black {
  --bs-text-opacity: 1;
  color: rgba(var(--bs-black-rgb), var(--bs-text-opacity)) !important;
}

.fw-bold {
  font-weight: 700 !important;
}
</style>
<script>
    function handleRoleChange() {
        const role = document.getElementById('role').value;
        const nipField = document.getElementById('nip-field');
        const nimField = document.getElementById('nim-field');

        // Tampilkan hanya field yang sesuai
        if (role === 'mahasiswa') {
            nimField.style.display = 'block';
            nipField.style.display = 'none';
        } else if (role === 'konselor') {
            nimField.style.display = 'none';
            nipField.style.display = 'block';
        } else {
            // Untuk role lain, sembunyikan keduanya
            nimField.style.display = 'none';
            nipField.style.display = 'none';
        }
    }

    // Jalankan fungsi saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function () {
        handleRoleChange();
    });
</script>
@endsection
