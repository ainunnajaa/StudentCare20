@extends('layouts.app')

@php use Carbon\Carbon; @endphp

@section('title', 'Dashboard Konselor')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold text-black">Dashboard Konselor</h1>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="alert alert-success fade-in-up">{{ session('success') }}</div>
    @endif

    <!-- Notifikasi Booking Baru -->
    @if($pendingBookings->count())
        <div class="mt-3 fade-in-up">
            <div class="alert alert-info">
                <h5>Notifikasi Booking Baru</h5>
                <ul class="mb-0">
                    @foreach($pendingBookings as $booking)
                        @php
                            $waktuMulai = Carbon::parse($booking->jadwal->waktu);
                        @endphp
                        @if(now()->lt($waktuMulai))
                            <li class="mb-2">
                                Mahasiswa <strong>{{ $booking->mahasiswa->name }}</strong> 
                                telah booking jadwal <strong>{{ $booking->jadwal->waktu }}</strong>.
                                <a href="{{ route('jadwals.index') }}">Lihat jadwal</a>

                                <!-- Form konfirmasi -->
                                <form method="POST" action="{{ route('bookings.confirm', $booking->id) }}" class="d-inline-block ms-2">
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

    <!-- Kartu Selamat Datang -->
    <div class="welcome-card mb-4 d-flex justify-content-between align-items-center p-4 rounded-4 fade-in-up">
        <div>
            <h1 class="text-white fs-5">Selamat datang Konselor, {{ auth()->user()->name }}!</h1>
            <p class="mb-0">Terima kasih telah menjadi bagian dari perjalanan healing dan pengembangan diri mahasiswa.</p>
            <p class="mt-0">Yuk, mulai bantu mereka hari ini dengan menjadwalkan sesi konseling.</p> <br>
            <a href="{{ route('jadwals.create') }}" class="btm btn-light btn-lg mt-2" onclick="return checkBiodata()">Tambah Jadwal</a>
        </div>
    </div>

    <!-- Peringatan Biodata -->
    @if(!$user->nip || !$user->tanggal_lahir || !$user->whatsapp)
        <div class="alert alert-warning fade-in-up">
            Anda belum mengisi biodata. <a href="{{ route('profile.form') }}">Isi sekarang</a>
        </div>
    @endif

    <!-- Ringkasan -->
    <h5 class="section-title fade-in-up" style="animation-delay: 0.1s;">Ringkasan Untuk Anda</h5>

    <div class="row mb-4">
        <div class="col-md-4 fade-in-up">
            <div class="card p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted">Jumlah Mahasiswa Ditangani</div>
                        <h3 class="fw-bold">{{ $jumlahMahasiswa }}</h3>
                    </div>
                    <i class="bi bi-person-check-fill text-primary fs-2"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4 fade-in-up" style="animation-delay: 0.1s;">
            <div class="card p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted">Sesi Konseling Selesai</div>
                        <h3 class="fw-bold">{{ $totalSelesai }}</h3>
                    </div>
                    <i class="bi bi-check-circle-fill text-success fs-2"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4 fade-in-up" style="animation-delay: 0.2s;">
            <div class="card p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted">Booking Menunggu Konfirmasi</div>
                        <h3 class="fw-bold">{{ $pendingBookings->count() }}</h3>
                    </div>
                    <i class="bi bi-hourglass-split text-warning fs-2"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rata-rata Rating -->
<div class="container mb-5">
    <h5 class="section-title fade-in-up" style="animation-delay: 0.1s;">Rating Oleh Mahasiswa</h5>
    <div class="row fade-in-up" style="animation-delay: 0.3s;">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted">Rata-rata Rating</div>
                        <h3 class="fw-bold">
                            {{ number_format($rataRataRating ?? 0, 2) }}
                            <i class="bi bi-star-fill text-warning"></i>
                        </h3>
                    </div>
                    <i class="bi bi-bar-chart-line-fill text-info fs-2"></i>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@push('styles')
<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

<style>
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease forwards;
    opacity: 0;
}

.welcome-card {
    background: linear-gradient(to right, #ff9a9e, #ff797e);
    color: white;
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
}

.btm:hover {
    background-color: #ff9a9e;
    box-shadow: 0 6px 12px rgba(255, 107, 139, 0.7);
}

.section-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #d23669;
    text-align: left;
    margin-top: 50px;
    margin-bottom: 20px;
    opacity: 0;
    animation: fadeInUp 0.6s ease forwards;
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

@push('scripts')
<script>
function checkBiodata() {
    const role = "{{ auth()->user()->role }}";
    if (role !== 'konselor') return true;

    const nip = "{{ auth()->user()->nip }}";
    const tanggal_lahir = "{{ auth()->user()->tanggal_lahir }}";
    const whatsapp = "{{ auth()->user()->whatsapp }}";

    if (!nip || !tanggal_lahir || !whatsapp) {
        alert("Anda harus mengisi biodata terlebih dahulu!");
        window.location.href = "{{ route('profile.form') }}";
        return false;
    }

    return true;
}
</script>
@endpush
