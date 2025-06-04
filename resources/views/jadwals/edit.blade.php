@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Edit Jadwal Konseling</h2>

    <form action="{{ route('jadwals.update', $jadwal) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Konselor</label>
            <select name="konselor_id" class="form-select" required>
                @foreach ($konselors as $konselor)
                    <option value="{{ $konselor->id }}" {{ $jadwal->konselor_id == $konselor->id ? 'selected' : '' }}>
                        {{ $konselor->name }}
                    </option>
                @endforeach
            </select>
            @error('konselor_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Waktu</label>
            <input type="datetime-local" name="waktu" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($jadwal->waktu)) }}" required>
            @error('waktu') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select" required>
                @foreach (['available', 'booked', 'done'] as $status)
                    <option value="{{ $status }}" {{ $jadwal->status == $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
            @error('status') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="{{ route('jadwals.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
