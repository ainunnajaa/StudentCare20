@extends('layouts.app')

@section('content')
<style>
/* Styling heading */
h2 {
    font-size: calc(1.375rem + 1.5vw);
    font-weight: 700 !important;
    color: rgba(var(--bs-black-rgb), 1) !important;
    margin-bottom: 1.5rem;
}

/* Card container */
.rating-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

/* Card tiap rating */
.rating-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(1,1,1,0.15);
    padding: 1rem 1.2rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

/* Container untuk user info (avatar + nama) */
.rating-user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

/* Avatar mahasiswa */
.rating-user-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}

/* Nama mahasiswa */
.rating-user {
    font-weight: 700;
    font-size: 1.1rem;
    color: #333;
}

/* Rating bintang */
.rating-stars {
    color: #ffc107;
    font-size: 1.5rem;
}

/* Komentar */
.rating-comment {
    font-size: 1rem;
    color: #555;
    white-space: pre-line; /* biar new line di komentar terlihat */
}

/* Tanggal rating */
.rating-date {
    font-size: 0.85rem;
    color: #888;
    text-align: right;
}

/* Jika tidak ada rating */
.no-rating {
    font-size: 1rem;
    color: #666;
    font-style: italic;
    margin-top: 2rem;
}
</style>

<div class="container mt-5">
    <h2>Rating dari Mahasiswa untuk Konselor {{ $konselor->name }}</h2>

    @if($ratings->isEmpty())
        <p class="no-rating">Belum ada rating untuk konselor ini.</p>
    @else
        <div class="rating-list">
            @foreach($ratings as $rating)
                @php
                    $mahasiswa = $rating->booking->mahasiswa ?? null;
                    $namaMahasiswa = $mahasiswa ? urlencode($mahasiswa->name) : 'Mahasiswa';
                    $fotoMahasiswa = $mahasiswa && $mahasiswa->foto
                        ? asset('storage/' . $mahasiswa->foto)
                        : "https://ui-avatars.com/api/?name={$namaMahasiswa}&background=f8bbd0&color=fff&rounded=true&size=40";
                @endphp

                <div class="rating-card">
                    <div class="rating-user-info">
                        <img src="{{ $fotoMahasiswa }}" alt="Avatar {{ $mahasiswa->name ?? 'Mahasiswa' }}" class="rating-user-avatar" />
                        <div class="rating-user">{{ $mahasiswa->name ?? 'Mahasiswa Tidak Diketahui' }}</div>
                    </div>
                    <div class="rating-stars" aria-label="Rating: {{ $rating->rating }} dari 5 bintang">
                        @for ($i = 1; $i <= 5; $i++)
                            {!! $i <= $rating->rating ? '&#9733;' : '&#9734;' !!}
                        @endfor
                    </div>
                    @if($rating->comment)
                        <div class="rating-comment">{{ $rating->comment }}</div>
                    @endif
                    <div class="rating-date">{{ $rating->created_at->translatedFormat('d M Y, H:i') }}</div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
