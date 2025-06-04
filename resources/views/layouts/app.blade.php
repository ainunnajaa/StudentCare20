<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'StudentCare') }}</title>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    html, body {
      height: 100%;
      margin: 0;
    }

    body {
      display: flex;
      flex-direction: column;
      font-family: 'Poppins', sans-serif;
      background: #f8f9fa;
    }

    main {
      flex: 1;
    }

    .navbar {
      background: linear-gradient(135deg, #ff9a9e 0%, #ff9a9e 100%);
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      padding: 20px 40px;
    }

    .navbar-brand,
    .nav-link,
    .navbar-toggler-icon {
      color: white !important;
    }

    .nav-link:hover,
    .btn-link:hover {
      color: #212529 !important;
    }

    .btn-link.nav-link {
      color: white !important;
    }

    .container-content {
      background-color: white;
      padding: 30px;
      margin: 30px auto;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .btn {
      background-color: #ff6b8b;
      color: white;
      font-weight: bold;
      border: none;
      padding: 10px 20px;
      border-radius: 10px;
      font-size: 14px;
      transition: background-color 0.2s ease;
    }

    .btn:hover {
      background-color: #d23669;
    }

    footer {
      background-color: #1f1f1f;
      color: white;
      padding: 30px 20px;
      text-align: center;
    }

    footer h3 {
      font-size: 1.5rem;
      font-weight: bold;
      margin-bottom: 15px;
    }

    footer p {
      font-size: 1rem;
      color: #ccc;
      margin-bottom: 20px;
    }

    footer .social-icons a {
      color: white;
      margin: 0 10px;
      font-size: 24px;
      text-decoration: none;
    }

    footer .social-icons a:hover {
      color: #ff6b8b;
    }

    @media (max-width: 768px) {
      .container-content {
        padding: 15px;
        margin: 15px auto;
        border-radius: 10px;
      }

      .navbar {
        padding: 15px 20px;
      }

      .navbar-brand {
        font-size: 20px;
      }

      .navbar img {
        width: 40px;
      }

      footer {
        padding: 20px 10px;
      }

      footer h3 {
        font-size: 1.2rem;
      }

      footer p {
        font-size: 0.9rem;
      }
    }
  </style>

  @stack('styles')
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <img src="{{ asset('gambar/frame.png') }}" alt="Framer" width="57" class="me-2" />
    <a class="navbar-brand" href="{{ route('dashboard') }}" style="font-weight:bold; font-size:24px">
      StudentCare
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        @auth
          @php
            $user = auth()->user();
          @endphp

          @if($user->role === 'konselor')
            <li class="nav-item"><a class="nav-link" href="{{ route('konselor.dashboard') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('jadwals.index') }}">Kelola Jadwal</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('konselor.notifikasi') }}">Notifikasi</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('ratings.konselor', $user->id) }}">Ratings</a></li>
          @elseif($user->role === 'mahasiswa')
            <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.dashboard') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('konselor.index') }}">Konselor</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('bookings.index') }}">Booking</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('ratings.history') }}">Riwayat Rating</a></li>
          @elseif($user->role === 'admin')
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Kelola User</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.jadwals.index') }}">Kelola Jadwal</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('admin.ratings.mahasiswa') }}">Riwayat Rating Mahasiswa</a></li>
          @endif

          <!-- Dropdown Profil -->
<li class="nav-item dropdown">
  <x-dropdown align="right" width="48">
    <x-slot name="trigger">
      <button class="nav-link dropdown-toggle bg-transparent border-0 d-flex align-items-center" type="button">
        @if ($user->profile_photo)
          <img
            src="{{ asset('storage/' . $user->profile_photo) }}"
            alt="Foto Profil"
            class="me-2"
            style="width:30px; height:30px; border-radius:50%; object-fit:cover; display:block;">
        @else
          <img
            src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=ff9a9e&color=fff&rounded=true&size=30"
            alt="Avatar"
            class="me-2"
            style="width:30px; height:30px; border-radius:50%; display:block;">
        @endif
        <span class="text-white">{{ $user->name }}</span>
      </button>
    </x-slot>

    <x-slot name="content">
      <x-dropdown-link :href="route('profile.edit')">
        {{ __('Profile') }}
      </x-dropdown-link>

      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <x-dropdown-link :href="route('logout')"
          onclick="event.preventDefault(); this.closest('form').submit();">
          {{ __('Log Out') }}
        </x-dropdown-link>
      </form>
    </x-slot>
  </x-dropdown>
</li>

        @else
          <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>

  <!-- Konten -->
  <main class="container container-content">
    @yield('content')
  </main>

  <!-- Footer -->
  <footer>
    <div class="footer-content">
      <h3>StudentCare</h3>
      <p>©️ 2025 StudentCare. All rights reserved.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  @stack('scripts')
</body>
</html>
