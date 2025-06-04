@extends('layouts.app')

@php use Carbon\Carbon; @endphp

@section('content')

<div class="container mt-4">
    <h1 class="fw-bold text-black">Daftar Booking Saya</h1>
</div>

<!-- Biodata Warning -->
@if(!auth()->user()->nim || !auth()->user()->jurusan || !auth()->user()->tanggal_lahir || !auth()->user()->whatsapp)
    <div class="alert alert-warning fade-in-up">
        Anda belum mengisi biodata. <a href="{{ route('profile.form') }}">Isi sekarang</a>
    </div>
@endif
<div class="mt-4">

    <!-- Tombol Booking di atas -->
    <a href="{{ route('bookings.create') }}" class="btm mt-2 mb-4 d-inline-block" onclick="return checkBiodata()">+ Booking Jadwal Baru</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($bookings->count())
    @php
        $sortedBookings = $bookings->sortByDesc(fn($b) => $b->jadwal->waktu)->values();
    @endphp
    <div class="booking-cards">
        @foreach($sortedBookings as $index => $booking)
        @php
            $jadwal = $booking->jadwal;
            $waktuMulai = Carbon::parse($jadwal->waktu);
            $waktuSelesai = $waktuMulai->copy()->addMinutes(60);
            $now = Carbon::now();

            $whatsapp = $jadwal->konselor->whatsapp ? ltrim($jadwal->konselor->whatsapp, '+') : null;

            $statusLabel = [
                'done' => ['label' => 'Selesai', 'class' => 'status-done'],
                'booked' => ['label' => 'Dikonfirmasi', 'class' => 'status-booked'],
                'pending' => ['label' => 'Menunggu Konfirmasi', 'class' => 'status-pending'],
                'not_confirmed' => ['label' => 'Tidak di Konfirmasi', 'class' => 'status-unknown'],
            ][$booking->status] ?? ['label' => 'Tidak Dikenal', 'class' => 'status-unknown'];

            $isSessionStarted = $now->greaterThanOrEqualTo($waktuMulai);
        @endphp

        <div class="booking-card" style="animation-delay: {{ 0.1 * $index }}s;">
            <div class="booking-icon">
                <span>📅</span>
            </div>
            <div class="booking-content">
                <h4 class="fw-bold mb-1">{{ $jadwal->konselor->name }}</h4>
                <div class="text-muted small">Jadwal Konseling</div>
            </div>
            <div class="booking-time text-end">
                <div class="booking-date">
                    {{ $waktuMulai->isToday() ? 'Hari Ini' : ($waktuMulai->isTomorrow() ? 'Besok' : $waktuMulai->translatedFormat('l, d M')) }}
                </div>
                <div class="booking-hour">
                    {{ $waktuMulai->format('H:i') }} - {{ $waktuSelesai->format('H:i') }}
                </div>
                <div class="booking-status mt-2 {{ $statusLabel['class'] }}">
                    {{ $statusLabel['label'] }}
                </div>
            </div>

            <div class="booking-action mt-2 w-100 d-flex justify-content-between align-items-center">
                <div>
                    @if($booking->status === 'done')
                        <span class="badge bg-success">Sudah Selesai</span>
                    @elseif($booking->status === 'booked')
                        @if(!$isSessionStarted)
                            <span class="text-muted">Menunggu</span>
                        @else
                            @if($whatsapp)
                                <!-- Tombol WhatsApp untuk melanjutkan percakapan -->
                                <a href="javascript:void(0);" onclick="kirimPesanWhatsApp('{{ $whatsapp }}', '{{ $jadwal->konselor->name }}', '{{ auth()->user()->name }}', '{{ auth()->user()->nim }}')" class="btn btn-sm btn-success">Lanjut WhatsApp</a>
                            @else
                                <span class="text-warning">Nomor WhatsApp belum diisi</span>
                            @endif
                        @endif
                    @elseif($booking->status === 'not_confirmed')
                        <span class="text-danger">Tidak di Konfirmasi</span>
                    @else
                        <span class="text-muted">Menunggu Konfirmasi</span>
                    @endif
                </div>

               <div class="d-flex gap-2 align-items-center flex-wrap">
    @if(
        ($booking->status === 'pending' && $now->greaterThanOrEqualTo($waktuSelesai)) ||
        ($booking->status === 'done') ||
        ($booking->status === 'not_confirmed')
    )
        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus booking ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger btn-sm">🗑 Hapus</button>
        </form>
    @else
        <span class="text-muted">Tidak bisa dihapus</span>
    @endif

    @if($booking->status === 'done')
        @if($booking->rating)
            <span class="text-success small">✅ Sudah Diberi Rating</span>
        @else
            <a href="{{ route('ratings.create', $booking->id) }}" class="btn btn-outline-primary btn-sm">⭐ Beri Rating</a>
        @endif
    @endif
</div>

            </div>
        </div>
        @endforeach
    </div>

    {{ $bookings->links() }}
    @else
        <p>Belum ada booking.</p>
    @endif
</div>

<!-- Styling CSS -->
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
  align-items: flex-start;
  gap: 1rem;
  flex-wrap: wrap;
  position: relative;
  flex-direction: row;
  animation: fadeInUp 0.5s ease forwards;
  opacity: 0;
  transform: translateY(20px);
  animation-fill-mode: forwards;
}
.booking-card:hover {
  box-shadow: 0 8px 25px rgba(255, 107, 139, 0.4);
  transform: translateY(-6px);
  transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.booking-icon {
  background-color: #fce4ec;
  border-radius: 12px;
  width: 48px;
  height: 48px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 22px;
  flex-shrink: 0;
  transition: transform 0.3s ease;
}
.booking-card:hover .booking-icon {
  transform: scale(1.1);
}

.booking-content {
  flex-grow: 1;
  min-width: 150px;
}
.booking-content h4 {
  font-size: 1.2rem;
}
.booking-content .small {
  font-size: 0.85rem;
}

.booking-time {
  min-width: 140px;
  text-align: right;
  font-weight: 500;
  color: #333;
  transition: color 0.3s ease;
}
.booking-card:hover .booking-time {
  color: #ff6b8b;
}

.booking-status {
  font-size: 0.85rem;
  font-weight: bold;
}

.status-done { color: green; }
.status-booked { color: #007bff; }
.status-pending { color: orange; }
.status-unknown { color: gray; }

.booking-action {
  width: 100%;
  margin-top: 0.5rem;
  display: flex;
  justify-content: space-between;
  gap: 0.5rem;
  flex-wrap: wrap;
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

/* Styling H1 */
h1, .h1 {
    font-size: calc(1.375rem + 1.5vw);
    margin-top: 0;
    margin-bottom: .5rem;
    line-height: 1.2;
}

/* Styling untuk teks hitam */
.text-black {
    --bs-text-opacity: 1;
    color: rgba(var(--bs-black-rgb), var(--bs-text-opacity)) !important;
}

/* Styling font bold */
.fw-bold {
    font-weight: 700 !important;
}
</style>

<!-- Script Cek Biodata -->
<script>
function checkBiodata() {
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

// Fungsi untuk membuka WhatsApp dengan pesan otomatis
function kirimPesanWhatsApp(whatsapp, konselorName, mahasiswaName, nimMahasiswa) {
    // Menyusun pesan otomatis
    const pesan = `Assalamualaikum, Halo Konselor ${konselorName}, selamat pagi/siang/sore. saya ${mahasiswaName} dengan NIM ${nimMahasiswa}, ingin memulai sesi konseling.`;

    // Mengonversi pesan menjadi URL encode agar bisa dikirim lewat WhatsApp
    const encodedPesan = encodeURIComponent(pesan);

    // Membuka WhatsApp dengan pesan otomatis
    window.open(`https://wa.me/${whatsapp}?text=${encodedPesan}`, '_blank');
}
</script>

@endsection