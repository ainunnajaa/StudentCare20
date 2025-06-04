@extends('layouts.app')

@section('title', 'Isi Biodata Konselor')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold text-black">Isi Biodata Konselor</h1>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="alert alert-success fade-in-up">{{ session('success') }}</div>
    @endif

    <!-- Form Card -->
    <div class="card p-4 shadow-sm rounded-4 fade-in-up mt-3">
        <form action="{{ route('profile.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="nip" class="form-label fw-bold">NIP</label>
                <input type="text" class="form-control" id="nip" name="nip" value="{{ old('nip', $user->nip) }}" required>
            </div>

            <div class="mb-3">
        <label for="jenis_kelamin" class="form-label fw-bold">Jenis Kelamin</label>
        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin">
            <option value="" disabled {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == '' ? 'selected' : '' }}>Pilih jenis kelamin</option>
            <option value="laki-laki" {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="perempuan" {{ old('jenis_kelamin', $user->jenis_kelamin ?? '') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
        @error('jenis_kelamin') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label fw-bold">Tanggal Lahir</label>
                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir', $user->tanggal_lahir) }}" required>
            </div>

            <div class="mb-3">
                <label for="whatsapp" class="form-label fw-bold">WhatsApp</label>
                <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ old('whatsapp', $user->whatsapp) }}" required>
            </div>

            <button type="submit" class="btm mt-3">Simpan Biodata</button>
        </form>
    </div>
</div>

<!-- Styling CSS -->
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
@endsection
