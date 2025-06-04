@extends('layouts.app')

@section('content')
<style>
/* Styling font dan heading agar konsisten dengan halaman daftar booking */
h2, h1, .h1 {
    font-size: calc(1.375rem + 1.5vw);
    margin-top: 0;
    margin-bottom: .5rem;
    line-height: 1.2;
    font-weight: 700 !important;
    color: rgba(var(--bs-black-rgb), 1) !important;
}

/* Styling container agar jarak top konsisten */
.container.mt-5 {
    margin-top: 1.5rem !important; /* sama dengan mt-4 pada daftar booking */
}

/* Styling tombol bintang rating */
.star-rating {
    direction: rtl;
    font-size: calc(1.375rem + 1.5vw); /* samakan dengan heading font size */
    unicode-bidi: bidi-override;
    display: inline-flex;
    cursor: pointer;
}

.star-rating input[type="radio"] {
    display: none;
}

.star-rating label {
    color: #ccc;
    padding: 0 5px;
    transition: color 0.2s;
}

.star-rating label:hover,
.star-rating label:hover ~ label,
.star-rating input[type="radio"]:checked ~ label {
    color: #ffc107; /* warna kuning bintang */
}

/* Styling tombol kirim rating agar konsisten dengan tombol lainnya */
.btn-primary {
    background-color: #ff6b8b;
    border-color: #ff6b8b;
    font-weight: 700;
    padding: 10px 20px;
    border-radius: 10px;
    font-size: 14px;
    transition: background-color 0.2s ease, box-shadow 0.3s ease;
}

.btn-primary:hover {
    background-color: #ff9a9e;
    border-color: #ff9a9e;
    box-shadow: 0 6px 12px rgba(255, 107, 139, 0.7);
}

/* Styling textarea dan label agar rapi */
.form-label {
    font-weight: 700;
    font-size: calc(1rem + 0.2vw);
    color: rgba(var(--bs-black-rgb), 0.9);
}

.form-control {
    font-size: 1rem;
    border-radius: 10px;
    padding: 0.5rem 0.75rem;
}

/* Margin bawah elemen form */
.mb-3 {
    margin-bottom: 1rem;
}
</style>

<div class="container mt-5">
    <h2>Beri Rating untuk Konselor {{ $booking->jadwal->konselor->name }}</h2>

    <form action="{{ route('ratings.store', $booking->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Rating (1 - 5)</label>
            <div class="star-rating" role="radiogroup" aria-label="Rating Konselor">
                @for ($i = 5; $i >= 1; $i--)
                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" required>
                    <label for="star{{ $i }}" title="{{ $i }} Bintang">&#9733;</label>
                @endfor
            </div>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Komentar (Opsional)</label>
            <textarea name="comment" id="comment" class="form-control" rows="3" placeholder="Tulis komentar..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Rating</button>
    </form>
</div>

<script>
    // Optional: Agar keyboard navigation dan klik bekerja mulus
    document.querySelectorAll('.star-rating input[type=radio]').forEach(input => {
        input.addEventListener('change', () => {
            // Bisa dipakai untuk aksi tambahan jika mau
            console.log('Rating dipilih:', input.value);
        });
    });
</script>
@endsection
