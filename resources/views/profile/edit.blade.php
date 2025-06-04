<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil - StudentCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <style>
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: #f8f9fa;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
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
      margin-top: auto;
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

    .py-12 {
      padding-top: 2rem !important;
      padding-bottom: 2rem !important;
      padding-right: 5rem;
      padding-left: 5rem;
    }

    .max-w-7xl {
      max-width: 80rem;
      margin-left: auto;
      margin-right: auto;
      padding-left: 0.5rem !important;
      padding-right: 0.5rem !important;
    }

    .space-y-6 > * + * {
      margin-top: 1rem !important;
    }

    @media (max-width: 992px) {
      .py-12 {
        padding-left: 2rem;
        padding-right: 2rem;
      }
    }

    @media (max-width: 768px) {
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

      .py-12 {
        padding-left: 1rem;
        padding-right: 1rem;
      }

      .max-w-7xl {
        padding-left: 0;
        padding-right: 0;
      }

      .max-w-xl {
        max-width: 100% !important;
      }
    }
    </style>
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
            @elseif($user->role === 'mahasiswa')
              <li class="nav-item"><a class="nav-link" href="{{ route('mahasiswa.dashboard') }}">Dashboard</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('konselor.index') }}">Konselor</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('bookings.index') }}">Booking</a></li>
            @elseif($user->role === 'admin')
              <li class="nav-item"><a class="nav-link" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('admin.users.index') }}">Kelola User</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('admin.jadwals.index') }}">Kelola Jadwal</a></li>
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
  <main class="py-12">
    <div class="max-w-7xl mx-auto sm:px-2 lg:px-4 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
            <div class="max-w-xl">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
  </main>

  <!-- Footer -->
  <footer>
    <div class="footer-content">
      <h3>StudentCare</h3>
      <p>©️ 2025 StudentCare. All rights reserved.</p>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
