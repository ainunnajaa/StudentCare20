@extends('layouts.app')

@section('content')
<style>
h2 {
    font-size: calc(1.375rem + 1.5vw);
    font-weight: 700 !important;
    color: rgba(var(--bs-black-rgb), 1) !important;
    margin-bottom: 1.5rem;
}

.rating-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.rating-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(1,1,1,0.15);
    padding: 1rem 1.2rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.rating-konselor-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.rating-konselor-avatar {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    object-fit: cover;
    flex-shrink: 0;
}

.rating-konselor {
    font-weight: 700;
    font-size: 1.1rem;
    color: #333;
}

.rating-stars {
    color: #ffc107;
    font-size: 1.5rem;
}

.rating-comment {
    font-size: 1rem;
    color: #555;
    white-space: pre-line;
}

.rating-date {
    font-size: 0.85rem;
    color: #888;
    text-align: right;
}

.no-rating {
    font-size: 1rem;
    color: #666;
    font-style: italic;
    margin-top: 2rem;
}
</style>

<div class="container mt-5">
    <h2>Riwayat Rating yang Kamu Berikan</h2>

    @if($ratings->isEmpty())
        <p class="no-rating">Kamu belum memberikan rating kepada konselor manapun.</p>
    @else
        <div class="rating-list">
            @foreach($ratings as $rating)
                @php
                    $konselor = $rating->booking->jadwal->konselor ?? null;
                    $namaKonselor = $konselor ? urlencode($konselor->name) : 'Konselor';
                    $fotoKonselor = $konselor && $konselor->foto
                        ? asset('storage/' . $konselor->foto)
                        : "https://ui-avatars.com/api/?name={$namaKonselor}&background=bbdefb&color=ffffff&rounded=true&size=40";
                @endphp

                <div class="rating-card">
                    <div class="rating-konselor-info">
                        <img src="{{ $fotoKonselor }}" alt="Avatar {{ $konselor->name ?? 'Konselor' }}" class="rating-konselor-avatar" />
                        <div class="rating-konselor">{{ $konselor->name ?? 'Konselor Tidak Diketahui' }}</div>
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
