@extends('layouts.app')

@section('title', 'Daftar Konselor')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold text-black">Daftar Konselor</h1>
    <p class="text-muted">Temukan konselor profesional yang siap membantu Anda</p>

    <!-- Form Pencarian -->
    <form method="GET" action="{{ route('konselor.index') }}" class="mb-4 search-form" autocomplete="off" role="search">
        <div class="input-group">
            <input
                type="search"
                name="search"
                class="form-control search-input"
                placeholder="Cari konselor..."
                value="{{ request('search') }}"
                aria-label="Cari konselor"
                autofocus
            >
            <button type="submit" class="btn btn-primary search-button" aria-label="Cari">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    <!-- Daftar Konselor -->
    <div class="konselor-cards">
        @forelse ($konselors as $index => $konselor)
            @php
                $avatarUrl = $konselor->profile_photo
                    ? asset('storage/' . $konselor->profile_photo)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($konselor->name) . '&background=90caf9&color=fff&rounded=true&size=64';
                $rating = number_format($konselor->ratings_avg_rating ?? 0, 2);
            @endphp
            <div class="konselor-card" style="animation-delay: {{ 0.1 * $index }}s;">
                <div class="d-flex align-items-center">
                    <img 
                        src="{{ $avatarUrl }}" 
                        alt="Avatar {{ $konselor->name }}" 
                        class="user-avatar rounded-circle me-3" 
                        width="64" 
                        height="64" 
                        style="object-fit: cover;"
                    >
                    <div class="flex-grow-1">
                        <h5 class="fw-bold mb-1">{{ $konselor->name }}</h5>
                        <p class="mb-1 text-secondary"><strong>NIP:</strong> {{ $konselor->nip }}</p>
                        <p class="mb-2 text-secondary"><i class="fas fa-envelope me-1"></i>{{ $konselor->email }}</p>

                        <div class="rating-badge d-inline-flex align-items-center px-2 py-1 rounded-pill">
                            <i class="fas fa-star me-1"></i>
                            <span class="fw-semibold">{{ $rating }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-warning">
                Tidak ada konselor yang ditemukan.
            </div>
        @endforelse
    </div>
</div>

<!-- Style -->
<style>
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.konselor-cards {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.konselor-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(1, 1, 1, 0.1);
    padding: 1rem 1.2rem;
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
    transform: translateY(20px);
    transition: box-shadow 0.3s ease, transform 0.3s ease;
    cursor: default;
}

.konselor-card:hover {
    box-shadow: 0 12px 30px rgba(33, 150, 243, 0.35);
    transform: translateY(-6px);
}

/* Pastikan avatar bulat sempurna */
.user-avatar {
    border-radius: 50% !important;
    width: 64px;
    height: 64px;
    object-fit: cover;
}

.search-form .input-group {
    display: flex;
    flex-wrap: nowrap;
    border-radius: 50rem;
    overflow: hidden;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    border: 1.5px solid #90caf9;
}

.search-input {
    border: none;
    padding: 0.75rem 1.25rem;
    min-height: 48px;
    flex: 1 1 auto;
    border-radius: 0;
    font-size: 1rem;
    color: #212529;
}

.search-input::placeholder {
    color: #6c757d;
}

.search-input:focus {
    box-shadow: none;
    outline: none;
}

.search-button {
    border: none;
    background-color: #42a5f5;
    color: white;
    padding: 0 1.2rem;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.3s ease;
    min-height: 48px;
}

.search-button:hover,
.search-button:focus {
    background-color: #1e88e5;
    outline: none;
}

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

@media (max-width: 576px) {
    .search-form .input-group {
        flex-direction: column;
        border-radius: 1rem;
    }

    .search-button {
        width: 100%;
        border-top: 1px solid #90caf9;
        border-radius: 0 0 1rem 1rem;
    }

    .search-input {
        border-radius: 1rem 1rem 0 0;
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
