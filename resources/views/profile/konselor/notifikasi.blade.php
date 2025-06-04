@extends('layouts.app')

@section('title', 'Notifikasi dan Riwayat Booking Konselor')

@section('content')

@if($pendingBookings->count())
<div class="container mt-3">
    <div class="alert alert-info">
        <h5>Notifikasi Booking Baru</h5>
        <ul class="mb-0">
            @foreach($pendingBookings as $booking)
                @php
                    $waktuMulai = \Carbon\Carbon::parse($booking->jadwal->waktu);
                    $now = \Carbon\Carbon::now();
                @endphp

                @if($now->lt($waktuMulai))
                    <li class="mb-2">
                        Mahasiswa <strong>{{ $booking->mahasiswa->name }}</strong> 
                        telah booking jadwal tanggal <strong>{{ $booking->jadwal->waktu }}</strong>.
                        <a href="{{ route('jadwals.index') }}">Lihat jadwal</a>

                        <!-- Form konfirmasi -->
                        <form method="POST" action="{{ route('bookings.confirm', $booking->id) }}" style="display:inline-block; margin-left: 10px;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Konfirmasi</button>
                        </form>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</div>
@endif

<div class="container mt-4">
    <h1 class="fw-bold text-black">Riwayat Booking Mahasiswa</h1>

    @if($allBookings->count())
    <div class="booking-cards">
        @foreach($allBookings as $index => $booking)
        @php
            $statusColor = [
                'pending' => 'warning',
                'booked' => 'primary',
                'done' => 'success',
                'not_confirmed' => 'danger',
            ][$booking->status] ?? 'secondary';

            $statusLabel = [
                'done' => ['label' => 'Selesai', 'class' => 'status-done'],
                'booked' => ['label' => 'Dikonfirmasi', 'class' => 'status-booked'],
                'pending' => ['label' => 'Menunggu Konfirmasi', 'class' => 'status-pending'],
                'not_confirmed' => ['label' => 'Tidak Dikonfirmasi', 'class' => 'status-unknown'],
            ][$booking->status] ?? ['label' => 'Tidak Diketahui', 'class' => 'status-unknown'];

            $waktu = \Carbon\Carbon::parse($booking->jadwal->waktu);
            $waktuSelesai = $waktu->copy()->addMinutes(60);
            $now = \Carbon\Carbon::now();

            $mahasiswa = $booking->mahasiswa;
            $namaMahasiswa = urlencode($mahasiswa->name);
            $avatarUrl = $mahasiswa->foto
                ? asset('storage/' . $mahasiswa->foto)
                : "https://ui-avatars.com/api/?name={$namaMahasiswa}&background=f8bbd0&color=fff&rounded=true&size=48";
        @endphp

        <div class="booking-card" style="animation-delay: {{ 0.1 * $index }}s;">
            <img src="{{ $avatarUrl }}" alt="Avatar {{ $mahasiswa->name }}" class="rounded-circle booking-avatar">
            <div class="booking-content">
                <h5 class="mb-1">{{ $mahasiswa->name }}</h5>
                <div class="text-muted">
                    {{ $booking->jadwal->jenis_konseling ?? 'Konseling' }}
                </div>
            </div>
            <div class="booking-time text-end">
                <div class="booking-date">
                    {{ $waktu->translatedFormat('l, d M') }}
                </div>
                <div class="booking-hour">
                    {{ $waktu->format('H:i') }} - {{ $waktuSelesai->format('H:i') }}
                </div>
                <div class="booking-status mt-2 {{ $statusLabel['class'] }}">
                    {{ $statusLabel['label'] }}
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-3">
        {{ $allBookings->links() }}
    </div>
    @else
        <p class="text-muted">Belum ada riwayat booking mahasiswa.</p>
    @endif
</div>

<!-- CSS Styling -->
<style>
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.booking-cards {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.booking-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(1,1,1,0.15);
    padding: 1rem 1.2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
    transform: translateY(20px);
}

.booking-card:hover {
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
    transform: translateY(-6px);
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.booking-avatar {
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    border-radius: 50%;
    object-fit: cover;
}

.booking-content {
    flex-grow: 1;
    min-width: 150px;
}

.booking-content h5 {
    margin-bottom: 0.25rem;
    font-weight: 600;
}

.booking-time {
    min-width: 140px;
    text-align: right;
    font-weight: 500;
    color: #333;
}

.booking-date {
    font-size: 0.9rem;
}

.booking-hour {
    font-size: 0.85rem;
    color: #555;
}

.booking-status {
    font-size: 0.85rem;
    font-weight: bold;
}

.status-done { color: green; }
.status-booked { color: #007bff; }
.status-pending { color: orange; }
.status-unknown { color: gray; }

@media (max-width: 576px) {
    .booking-card {
        flex-direction: column;
        align-items: flex-start;
        padding: 1rem;
        gap: 0.5rem;
    }

    .booking-avatar {
        width: 60px;
        height: 60px;
        margin-bottom: 0.5rem;
    }

    .booking-content {
        min-width: auto;
        width: 100%;
    }

    .booking-content h5 {
        font-size: 1.1rem;
        margin-bottom: 0.3rem;
    }

    .booking-time {
        min-width: auto;
        width: 100%;
        text-align: left;
        font-weight: 600;
        color: #444;
    }

    .booking-date,
    .booking-hour,
    .booking-status {
        font-size: 0.9rem;
    }

    .booking-status {
        margin-top: 0.3rem;
    }
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
