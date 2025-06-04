@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold text-black">Dashboard Admin</h1>

    <!-- Kartu Selamat Datang -->
    <div class="welcome-card mb-4 d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center p-4 rounded-4 fade-in-up">
        <div>
            <h1 class="text-white fs-5">Selamat datang, {{ auth()->user()->name }}!</h1>
            <p class="mb-2">Bagaimana kabarmu hari ini?</p>
        </div>
    </div>

    <!-- Judul Seksi -->
    <h5 class="section-title fade-in-up" style="animation-delay: 0.1s;">Statistik Umum</h5>

    <!-- Kartu Statistik -->
    <div class="row mb-4">
        <!-- Total Pengguna -->
        <div class="col-md-4 col-sm-6 col-12 mb-3 fade-in-up">
            <div class="card p-3 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted">Total Pengguna</div>
                        <h3 class="fw-bold">{{ $totalUsers }}</h3>
                    </div>
                    <i class="bi bi-people-fill text-primary fs-2"></i>
                </div>
            </div>
        </div>

        <!-- Total Mahasiswa -->
        <div class="col-md-4 col-sm-6 col-12 mb-3 fade-in-up">
            <div class="card p-3 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted">Total Mahasiswa</div>
                        <h3 class="fw-bold">{{ $totalMahasiswa }}</h3>
                    </div>
                    <i class="bi bi-mortarboard-fill text-success fs-2"></i>
                </div>
            </div>
        </div>

        <!-- Total Konselor -->
        <div class="col-md-4 col-sm-6 col-12 mb-3 fade-in-up">
            <div class="card p-3 shadow-sm h-100">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted">Total Konselor</div>
                        <h3 class="fw-bold">{{ $totalKonselor }}</h3>
                    </div>
                    <i class="bi bi-person-badge-fill text-danger fs-2"></i>
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
