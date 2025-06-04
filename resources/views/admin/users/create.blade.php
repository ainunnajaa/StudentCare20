@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold text-black">Tambah User</h1>

    <form action="{{ route('admin.users.store') }}" method="POST" class="fade-in-up" style="animation-delay: 0.1s;">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input name="name" value="{{ old('name') }}" class="form-control" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input name="email" type="email" value="{{ old('email') }}" class="form-control" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

         <div class="mb-3">
            <label class="form-label">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-select" required onchange="handleRoleChange()">
                <option value="" selected disabled>Pilih jenis kelamin</option>
                @foreach ($jenis_kelamins as $jenis_kelamin)
                    <option value="{{ $jenis_kelamin }}" {{ old('jenis_kelamin') == $jenis_kelamin ? 'selected' : '' }}>
                        {{ ucfirst($jenis_kelamin) }}
                    </option>
                @endforeach
            </select>
            @error('role') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Role</label>
            <select name="role" id="role" class="form-select" required onchange="handleRoleChange()">
                @foreach ($roles as $role)
                    <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>
                        {{ ucfirst($role) }}
                    </option>
                @endforeach
            </select>
            @error('role') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- NIP - khusus konselor --}}
        <div class="mb-3" id="nip-field">
            <label class="form-label">Nomor Induk Pegawai (contoh: 19840326 202301 2 008)</label>
            <input name="nip" type="text" value="{{ old('nip') }}" class="form-control" placeholder="Masukkan Nomor NIP">
            @error('nip') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- NIM - khusus mahasiswa --}}
        <div class="mb-3" id="nim-field">
            <label class="form-label">Nomor Induk Mahasiswa (contoh: 2305090006)</label>
            <input name="nim" type="text" value="{{ old('nim') }}" class="form-control" placeholder="Masukkan Nomor NIM">
            @error('nim') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        {{-- WhatsApp --}}
        <div class="mb-3" id="whatsapp-field">
            <label class="form-label">Nomor WhatsApp (contoh: 6285802264649)</label>
            <input name="whatsapp" type="text" value="{{ old('whatsapp') }}" class="form-control" placeholder="Masukkan Nomor WhatsApp">
            @error('whatsapp') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <input name="password" type="password" class="form-control" required>
            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input name="password_confirmation" type="password" class="form-control" required>
        </div>

        <button class="btn btm">Simpan</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>

@push('styles')
<style>
@keyframes fadeInUp {
  0% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}

.fade-in-up {
  animation: fadeInUp 0.6s ease forwards;
  opacity: 0;
}

.btm {
  background-color: #ff6b8b;
  color: white;
  font-weight: bold;
  border: none;
  padding: 10px 20px;
  border-radius: 10px;
  cursor: pointer;
  text-decoration: none;
  font-size: 14px;
  transition: background-color 0.2s ease, box-shadow 0.3s ease;
  display: inline-block;
}

.btm:hover {
  background-color: #ff9a9e;
  box-shadow: 0 6px 12px rgba(255, 107, 139, 0.7);
}

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
@endpush

<script>
    function handleRoleChange() {
        const role = document.getElementById('role').value;
        const nipField = document.getElementById('nip-field');
        const nimField = document.getElementById('nim-field');

        if (role === 'konselor') {
            nipField.style.display = 'block';
            nimField.style.display = 'none';
        } else if (role === 'mahasiswa') {
            nipField.style.display = 'none';
            nimField.style.display = 'block';
        } else {
            nipField.style.display = 'none';
            nimField.style.display = 'none';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        handleRoleChange(); // inisialisasi saat halaman pertama kali dimuat
    });
</script>
@endsection
