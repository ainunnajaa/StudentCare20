@extends('layouts.app')

@section('title', 'Daftar Jadwal Konseling')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold text-black">Daftar Jadwal Konseling</h1>

    <!-- Biodata Warning hanya untuk konselor -->
    @if(auth()->user()->role === 'konselor' && 
        (!auth()->user()->nip || !auth()->user()->jenis_kelamin || !auth()->user()->tanggal_lahir || !auth()->user()->whatsapp))
        <div class="alert alert-warning fade-in-up">
            Anda belum mengisi biodata. <a href="{{ route('profile.form') }}">Isi sekarang</a>
        </div>
    @endif

    <!-- Tombol Tambah Jadwal dengan Cek Biodata -->
    <a href="{{ route('jadwals.create') }}" class="btn btn-primary mb-4" onclick="return checkBiodata()">
        <i class="bi bi-plus-circle"></i> Tambah Jadwal
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($jadwals->count())
        <div class="jadwal-cards">
            @foreach ($jadwals as $index => $jadwal)
            @php
                $waktu = \Carbon\Carbon::parse($jadwal->waktu);
                $formattedDate = $waktu->translatedFormat('l, d M Y');
                $formattedTime = $waktu->format('H:i');

                // Ambil data konselor
                $konselor = $jadwal->konselor;

                // Cek foto profil konselor di storage
                if ($konselor->profile_photo && file_exists(storage_path('app/public/' . $konselor->profile_photo))) {
                    $avatarUrl = asset('storage/' . $konselor->profile_photo);
                } else {
                    $namaKonselor = urlencode($konselor->name);
                    $avatarUrl = "https://ui-avatars.com/api/?name={$namaKonselor}&background=90caf9&color=fff&rounded=true&size=48";
                }

                // Tentukan class badge warna berdasarkan status
                switch(strtolower($jadwal->status)) {
                    case 'available':
                        $badgeClass = 'warning'; // kuning
                        break;
                    case 'done':
                        $badgeClass = 'success'; // hijau
                        break;
                    case 'booked':
                        $badgeClass = 'danger';  // merah
                        break;
                    default:
                        $badgeClass = 'secondary'; // warna default abu-abu
                }
            @endphp

            <div class="jadwal-card" style="animation-delay: {{ 0.1 * $index }}s;">
                <img src="{{ $avatarUrl }}" alt="Avatar {{ $konselor->name }}" class="rounded-circle jadwal-avatar">
                <div class="jadwal-content">
                    <h5 class="mb-1">{{ $konselor->name }}</h5>
                    <div class="text-muted">{{ $formattedDate }} pukul {{ $formattedTime }}</div>
                    <span class="badge bg-{{ $badgeClass }}">
                        {{ ucfirst($jadwal->status) }}
                    </span>
                </div>
                <div class="jadwal-actions text-end">
                    <a href="{{ route('jadwals.edit', $jadwal) }}" class="btn btn-sm btn-outline-warning btn-action">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <form action="{{ route('jadwals.destroy', $jadwal) }}" method="POST" onsubmit="return confirm('Hapus jadwal ini?')" style="display:inline-block; margin-left: 0.5rem;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger btn-action">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $jadwals->links('vendor.pagination.custom') }}
        </div>
    @else
        <p class="text-muted">Belum ada jadwal konseling.</p>
    @endif
</div>

<style>
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.jadwal-cards {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.jadwal-card {
    background: #fff;
    border-radius: 15px;
    box-shadow: 0 2px 10px rgba(1,1,1,0.1);
    padding: 1rem 1.2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    animation: fadeInUp 0.5s ease forwards;
    opacity: 0;
    transform: translateY(20px);
}

.jadwal-card:hover {
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
    transform: translateY(-6px);
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.jadwal-avatar {
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    border-radius: 50%;
    object-fit: cover;
}

.jadwal-content {
    flex-grow: 1;
    min-width: 150px;
}

.jadwal-actions {
    min-width: 150px;
    text-align: right;
    display: flex;
    align-items: center;
    justify-content: flex-end;
}

.btn-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    height: 36px;
    padding: 0 14px;
    font-size: 0.85rem;
    border-width: 1.8px;
    line-height: 1;
    white-space: nowrap;
    vertical-align: middle;
    user-select: none;
}

.jadwal-actions > a.btn-action {
    margin-right: 0.5rem;
}

.badge {
    font-size: 0.85rem;
    padding: 0.4em 0.6em;
}

/* --- Responsive for Mobile --- */
@media (max-width: 576px) {
    .jadwal-card {
        flex-direction: column;
        align-items: flex-start;
        padding: 1rem;
        gap: 0.75rem;
    }

    .jadwal-avatar {
        width: 60px;
        height: 60px;
        margin-bottom: 0.5rem;
    }

    .jadwal-content {
        min-width: auto;
        width: 100%;
    }

    .jadwal-content h5 {
        font-size: 1.1rem;
        margin-bottom: 0.25rem;
    }

    .jadwal-content .text-muted {
        font-size: 0.9rem;
    }

    .jadwal-actions {
        min-width: auto;
        width: 100%;
        text-align: left;
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .jadwal-actions .btn {
        flex: 1 1 auto;
        font-size: 0.85rem;
        padding: 0.4rem 0.6rem;
        height: 36px;
    }

    .jadwal-actions > a.btn-action {
        margin-right: 0;
    }

    form[style] {
        margin-left: 0;
    }
    
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
    const userRole = "{{ auth()->user()->role }}";
    if (userRole !== 'konselor') return true;

    const nip = "{{ auth()->user()->nip }}";
    const jenis_kelamin = "{{ auth()->user()->jenis_kelamin }}";
    const tanggal_lahir = "{{ auth()->user()->tanggal_lahir }}";
    const whatsapp = "{{ auth()->user()->whatsapp }}";

    if (!nip || !jenis_kelamin || !tanggal_lahir || !whatsapp) {
        alert("Anda harus mengisi biodata terlebih dahulu!");
        window.location.href = "{{ route('profile.form') }}";
        return false;
    }

    return true;
}
</script>

@endsection
