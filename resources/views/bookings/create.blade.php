@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold text-black">Pilih Jadwal</h1>

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label d-block mb-2">Konselor yang tersedia</label>

            <div class="row">
                @forelse($jadwals as $index => $jadwal)
                    @php
                        $konselor = $jadwal->konselor;
                        $avatarUrl = $konselor->profile_photo
                            ? asset('storage/' . $konselor->profile_photo)
                            : 'https://ui-avatars.com/api/?name=' . urlencode($konselor->name) . '&background=90caf9&color=fff&rounded=true&size=64';

                        $rating = number_format($konselor->ratings_avg_rating ?? 0, 2);
                    @endphp

                    <div class="col-md-6 mb-3">
                        <label class="card border @error('jadwal_id') border-danger @enderror p-3 w-100 konselor-card" style="cursor: pointer; animation-delay: {{ 0.1 * $index }}s;">
                            <div class="d-flex align-items-center">
                                <!-- Radio Button -->
                                <input type="radio" name="jadwal_id" value="{{ $jadwal->id }}" class="form-check-input me-3 mt-0" required>

                                <!-- Avatar -->
                                <img 
                                    src="{{ $avatarUrl }}" 
                                    alt="Avatar {{ $konselor->name }}" 
                                    class="user-avatar rounded-circle me-3" 
                                    width="64" 
                                    height="64"
                                >

                                <!-- Info Konselor -->
                                <div>
                                    <h5 class="fw-bold mb-1">{{ $konselor->name }}</h5>
                                    <p class="mb-1 text-secondary"><strong>NIP:</strong> {{ $konselor->nip }}</p>
                                    <p class="mb-1 text-secondary"><i class="fas fa-envelope me-1"></i>{{ $konselor->email }}</p>
                                    <p class="mb-1 text-secondary"><i class="fas fa-calendar-alt me-1"></i>{{ \Carbon\Carbon::parse($jadwal->waktu)->translatedFormat('l, d M Y H:i') }}</p>

                                    <div class="rating-badge d-inline-flex align-items-center px-2 py-1 rounded-pill mt-1">
                                        <i class="fas fa-star me-1"></i>
                                        <span class="fw-semibold">{{ $rating }}</span>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                @empty
                    <p class="text-muted">Belum ada jadwal tersedia.</p>
                @endforelse
            </div>

            @error('jadwal_id')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mt-3">
            <button class="btn btn-success">Booking</button>
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>

<!-- CSS Style -->
<style>
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.konselor-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(1, 1, 1, 0.15);
    transition: box-shadow 0.3s ease, transform 0.3s ease;
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
    transform: translateY(20px);
}
.konselor-card:hover {
    box-shadow: 0 8px 25px rgba(144, 202, 249, 0.4);
    transform: translateY(-6px);
}

/* Avatar bulat dan proporsional */
.user-avatar {
    border-radius: 50% !important;
    width: 64px;
    height: 64px;
    object-fit: cover;
}

/* Rating badge */
.rating-badge {
    background-color: #e3f2fd;
    color: #1976d2;
    font-size: 0.875rem;
    font-weight: 600;
    user-select: none;
}
.rating-badge i {
    color: #fbc02d;
}

/* Heading */
h1, .h1 {
    font-size: calc(1.375rem + 1.5vw);
    margin-top: 0;
    margin-bottom: .5rem;
    line-height: 1.2;
}

/* Teks dan font */
.text-black {
    --bs-text-opacity: 1;
    color: rgba(var(--bs-black-rgb), var(--bs-text-opacity)) !important;
}
.fw-bold {
    font-weight: 700 !important;
}
</style>
@endsection
