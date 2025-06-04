@extends('layouts.app')

@section('title', 'Daftar User')

@section('content')
<div class="container mt-4">
    <h1 class="fw-bold text-black">Daftar User</h1>
    <p class="text-muted">Daftar Pengguna Konselor dan Mahasiswa</p>
    <br>

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-4">
        <i class="bi bi-plus-circle"></i> Tambah User
    </a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($users->count())
        <div class="user-cards">
            @foreach ($users as $index => $user)
            @php
                $avatarUrl = $user->profile_photo 
                    ? asset('storage/' . $user->profile_photo)
                    : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=' . match($user->role) {
                        'mahasiswa' => 'f48fb1',
                        'konselor' => '64b5f6',
                        default => '90caf9',
                    } . '&color=fff&rounded=true&size=48';
            @endphp

            <div class="user-card" style="animation-delay: {{ 0.1 * $index }}s;">
                <img src="{{ $avatarUrl }}" alt="Avatar" class="rounded-circle user-avatar">
                <div class="user-content">
                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <div class="text-muted">{{ $user->email }}</div>
                    <span class="badge role-{{ $user->role }}">{{ ucfirst($user->role) }}</span>
                </div>
                <div class="user-actions text-end">
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning btn-action">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?')" style="display:inline-block; margin-left: 0.5rem;">
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
            {{ $users->links('vendor.pagination.custom') }}
        </div>
    @else
        <p class="text-muted">Belum ada user.</p>
    @endif
</div>

<style>
@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(20px); }
    100% { opacity: 1; transform: translateY(0); }
}

.user-cards {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.user-card {
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

.user-card:hover {
    box-shadow: 0 8px 25px rgba(0, 123, 255, 0.3);
    transform: translateY(-6px);
    transition: box-shadow 0.3s ease, transform 0.3s ease;
}

.user-avatar {
    width: 48px;
    height: 48px;
    flex-shrink: 0;
    border-radius: 50%;
    object-fit: cover;
}

.user-content {
    flex-grow: 1;
    min-width: 150px;
}

.user-actions {
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

.user-actions > a.btn-action {
    margin-right: 0.5rem;
}

/* Badge Colors by Role */
.badge {
    font-size: 0.85rem;
    padding: 0.4em 0.6em;
    color: #fff;
}

.badge.role-mahasiswa {
    background-color: #f48fb1;
}

.badge.role-konselor {
    background-color: #64b5f6;
}

@media (max-width: 576px) {
    .user-card {
        flex-direction: column;
        align-items: flex-start;
        padding: 1rem;
        gap: 0.75rem;
    }

    .user-avatar {
        width: 60px;
        height: 60px;
        margin-bottom: 0.5rem;
    }

    .user-content {
        min-width: auto;
        width: 100%;
    }

    .user-content h5 {
        font-size: 1.1rem;
        margin-bottom: 0.25rem;
    }

    .user-content .text-muted {
        font-size: 0.9rem;
    }

    .user-actions {
        min-width: auto;
        width: 100%;
        text-align: left;
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        justify-content: flex-start;
    }

    .user-actions .btn {
        flex: 1 1 auto;
        font-size: 0.85rem;
        padding: 0.4rem 0.6rem;
        height: 36px;
    }

    .user-actions > a.btn-action {
        margin-right: 0;
    }

    form[style] {
        margin-left: 0;
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
