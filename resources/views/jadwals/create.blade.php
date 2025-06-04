@extends('layouts.app')

@section('title', 'Tambah Jadwal Konseling')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold text-black">Tambah Jadwal Konseling</h1>

    <form action="{{ route('jadwals.store') }}" method="POST" class="fade-in-up" style="animation-delay: 0.1s;">
        @csrf

        <div class="mb-3">
            <label class="form-label">Konselor</label>
            <select name="konselor_id" class="form-select" required>
                @foreach ($konselors as $konselor)
                    <option value="{{ $konselor->id }}">{{ $konselor->name }}</option>
                @endforeach
            </select>
            @error('konselor_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Waktu</label>
            <input type="datetime-local" name="waktu" class="form-control" required>
            @error('waktu') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btm">Simpan</button>
        <a href="{{ route('jadwals.index') }}" class="btn btn-secondary">Batal</a>
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
@endsection
