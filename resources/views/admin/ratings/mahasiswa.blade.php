@extends('layouts.app')

@section('title', 'Riwayat Rating Mahasiswa')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold text-black">Riwayat Rating Mahasiswa</h1>
    <p class="text-muted">Berikut adalah ulasan yang diberikan oleh mahasiswa terhadap konselor</p>

    <div class="rating-cards">
        @forelse ($ratings as $index => $rating)
            @php
                $mahasiswa = $rating->booking->mahasiswa;
                $konselor = $rating->booking->jadwal->konselor;

                $avatarMahasiswa = $mahasiswa->foto
                    ? asset('storage/' . $mahasiswa->foto)
                    : "https://ui-avatars.com/api/?name=" . urlencode($mahasiswa->name ?? 'Mahasiswa') . "&background=f48fb1&color=fff&rounded=true&size=64";

                $avatarKonselor = $konselor->foto
                    ? asset('storage/' . $konselor->foto)
                    : "https://ui-avatars.com/api/?name=" . urlencode($konselor->name ?? 'Konselor') . "&background=90caf9&color=fff&rounded=true&size=64";
            @endphp
            <div class="rating-card" style="animation-delay: {{ 0.1 * $index }}s;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex align-items-center">
                        <img src="{{ $avatarMahasiswa }}" alt="Mahasiswa" class="rounded-circle me-3" width="64" height="64" style="object-fit: cover; height: 64px; width: 64px;">
                        <div>
                            <h6 class="fw-bold mb-0">{{ $mahasiswa->name ?? 'Tidak diketahui' }}</h6>
                            <small class="text-muted">{{ $mahasiswa->email ?? '-' }}</small>
                            <br>
                            <small class="text-muted">NIM: {{ $mahasiswa->nim ?? '-' }}</small>
                        </div>
                    </div>

                    <div class="text-end">
                        <span class="badge bg-warning text-dark fs-6">
                            <i class="fas fa-star"></i> {{ $rating->rating }}
                        </span>
                        <br>
                        <small class="text-muted">{{ $rating->created_at->format('d M Y, H:i') }}</small>
                    </div>
                </div>

                <div class="mb-3">
                    <p class="mb-0">{{ $rating->comment ?? 'Tidak ada komentar.' }}</p>
                </div>

                <div class="d-flex align-items-center mt-3 pt-2 border-top">
                    <img src="{{ $avatarKonselor }}" alt="Konselor" class="rounded-circle me-3" width="56" height="56" style="object-fit: cover; height: 56px; width: 56px;">
                    <div>
                        <div class="fw-semibold">{{ $konselor->name ?? 'Tidak diketahui' }}</div>
                        <small class="text-muted">NIP: {{ $konselor->nip ?? '-' }}</small><br>
                        <small class="text-muted">{{ $konselor->email ?? '-' }}</small>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                Belum ada rating dari mahasiswa.
            </div>
        @endforelse

        <div class="mt-4">
            {{ $ratings->links() }}
        </div>
    </div>
</div>

<!-- Style -->
<style>
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.rating-cards {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.rating-card {
    background: #fff;
    border-radius: 16px;
    padding: 1.5rem;
    box-shadow: 0 2px 12px rgba(0,0,0,0.08);
    animation: fadeInUp 0.4s ease forwards;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
}

.rating-card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    transform: translateY(-4px);
}

.fw-bold {
    font-weight: 700 !important;
}

.text-black {
    color: #000 !important;
}

h1, .h1 {
    font-size: calc(1.375rem + 1.5vw);
    margin-top: 0;
    margin-bottom: .5rem;
    line-height: 1.2;
}
</style>
@endsection
