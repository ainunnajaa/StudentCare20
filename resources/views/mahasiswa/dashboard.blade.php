@extends('layouts.app')

@php use Carbon\Carbon; @endphp

@section('title', 'Dashboard Mahasiswa')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold text-black">Dashboard Mahasiswa</h1>

    <!-- Flash Message -->
    @if(session('success'))
        <div class="alert alert-success fade-in-up">{{ session('success') }}</div>
    @endif

    <!-- Kartu Selamat Datang -->
    <div class="welcome-card mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center p-4 rounded-4 fade-in-up">
        <div>
            <h1 class="text-white fs-5">Selamat datang, {{ auth()->user()->name }}!</h1>
            <p class="mb-2">Semoga harimu menyenangkan! Silakan cek jadwal konseling, ajukan permohonan, dan pantau statusnya di sini.</p>
            <a href="{{ route('bookings.create') }}" class="btm btn-light btn-lg mt-2" onclick="return checkBiodata()">Mulai Konseling</a>
        </div>
    </div>

     <!-- Biodata Warning -->
    @if(!$user->nim || !$user->jurusan || !$user->tanggal_lahir || !$user->whatsapp)
        <div class="alert alert-warning fade-in-up">
            Anda belum mengisi biodata. <a href="{{ route('profile.form') }}">Isi sekarang</a>
        </div>
    @endif

    <!-- Ringkasan untuk kamu -->
    <h5 class="section-title fade-in-up" style="animation-delay: 0.1s;">Ringkasan Untuk Kamu</h5>    

    <div class="row mb-4">
        <div class="col-md-4 col-sm-6 col-12 mb-3 fade-in-up">
            <div class="card p-3 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted">Riwayat Konseling</div>
                        <h3 class="fw-bold">{{ $totalBooking }}</h3>
                    </div>
                    <i class="bi bi-chat-dots-fill text-primary fs-2"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12 mb-3 fade-in-up" style="animation-delay: 0.1s;">
            <div class="card p-3 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted">Selesai</div>
                        <h3 class="fw-bold">{{ $totalSelesai }}</h3>
                    </div>
                    <i class="bi bi-check-circle-fill text-success fs-2"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6 col-12 mb-3 fade-in-up" style="animation-delay: 0.2s;">
            <div class="card p-3 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted">Jumlah Konselor</div>
                        <h3 class="fw-bold">{{ $jumlahKonselor }}</h3>
                    </div>
                    <i class="bi bi-people-fill text-purple fs-2"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Judul Seksi -->
    <h5 class="section-title fade-in-up" style="animation-delay: 0.3s;">Artikel yang Bisa Membantu Kamu</h5>

    <!-- Artikel -->
    <div class="row article-section">
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="article h-100 fade-in-up" style="animation-delay: 0s;">
                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSisEF8M3elcbq1GJvZbjGVdCvwMnFYf9sUNQ&s" alt="Bimbingan Konseling">
                <h4>Apa Itu Bimbingan Konseling? Teknik dan Fungsinya</h4>
                <a href="https://www.gramedia.com/literasi/bimbingan-konseling/" target="_blank">Baca Selengkapnya</a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="article h-100 fade-in-up" style="animation-delay: 0.1s;">
                <img src="https://sph.edu/wp-content/uploads/2024/02/Pentingnya-Bimbingan-Konseling-1200x720.jpg" alt="Bimbingan Konseling">
                <h4>6 Alasan Pentingnya Bimbingan Konseling</h4>
                <a href="https://sph.edu/id/blog-id/pentingnya-bimbingan-konseling/" target="_blank">Baca Selengkapnya</a>
            </div>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="article h-100 fade-in-up" style="animation-delay: 0.2s;">
                <img src="https://psbk.unikama.ac.id/wp-content/uploads/sites/33/2025/01/Foto-Web-100-scaled.jpg" alt="Bimbingan Konseling">
                <h4>Pengertian Bimbingan Konseling serta Manfaatnya</h4>
                <a href="https://psbk.unikama.ac.id/id/pengertian-bimbingan-konseling/" target="_blank">Baca Selengkapnya</a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
    display: inline-block;
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

.article-section {
    margin-top: 30px;
}

.article {
    background-color: white;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    height: 100%;
}

.article img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 15px;
}

.article h4 {
    font-size: 1.1rem;
    color: #d23669;
    margin-bottom: 10px;
    flex-grow: 1;
}

.article a {
    color: #ff6b8b;
    text-decoration: none;
    font-weight: bold;
}

.article a:hover {
    text-decoration: underline;
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

<!-- Script Cek Biodata -->
<script>
function checkBiodata() {
    const userRole = "{{ auth()->user()->role }}";
    if (userRole !== 'mahasiswa') return true;

    const nim = "{{ auth()->user()->nim }}";
    const jurusan = "{{ auth()->user()->jurusan }}";
    const tanggal_lahir = "{{ auth()->user()->tanggal_lahir }}";
    const whatsapp = "{{ auth()->user()->whatsapp }}";

    if (!nim || !jurusan || !tanggal_lahir || !whatsapp) {
        alert("Anda harus mengisi biodata terlebih dahulu!");
        window.location.href = "{{ route('profile.form') }}";
        return false;
    }

    return true;
}
</script>
@endsection
