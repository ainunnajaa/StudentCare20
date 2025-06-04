<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Verifikasi Email - StudentCare</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>

  <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #ff9a9e 0%, #fad0c4 100%);
    }

    body {
      display: flex;
      flex-direction: column;
    }

    main {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 40px 20px;
    }

    .login-container {
      max-width: 400px;
      width: 100%;
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .login-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #d23669;
    }

    .btn {
      background-color: #ff6b8b;
      color: white;
      font-weight: bold;
      border: none;
      padding: 12px;
      border-radius: 30px;
      cursor: pointer;
      width: 100%;
      margin-top: 10px;
      font-size: 16px;
      transition: background-color 0.2s ease;
    }

    .btn:hover {
      background-color: #d23669;
    }

    .btn-auth {
      background-color: #ff6b8b;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 30px;
      font-weight: bold;
      text-decoration: none;
      transition: all 0.2s ease;
    }

    .btn-auth:hover {
      background-color: #d23669;
    }

    .text-description {
      font-size: 14px;
      color: #555;
      margin-bottom: 15px;
      text-align: center;
    }

    .alert-success {
      background-color: #d4edda;
      color: #155724;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
    }

    .alert-danger {
      background-color: #f8d7da;
      color: #721c24;
      padding: 10px;
      border-radius: 5px;
      margin-bottom: 15px;
    }

    .alert-danger ul {
      margin-bottom: 0;
      padding-left: 20px;
    }

    .logout-link {
      color: #d23669;
      text-decoration: none;
      font-weight: bold;
      transition: all 0.2s ease;
    }

    .logout-link:hover {
      text-decoration: underline;
      color: #a82b56;
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

    /* Navbar styling */
    .navbar {
      padding: 20px 40px;
      background: linear-gradient(135deg, #ff9a9e 0%, #ff9a9e 100%) !important;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
    
    .navbar-toggler {
      border: none;
      padding: 0;
    }
    
    .navbar-toggler:focus {
      box-shadow: none;
    }
    
    .navbar-toggler-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
    }

    @media (max-width: 768px) {
      .navbar {
        padding: 15px 20px;
      }
      
      .btn-auth {
        padding: 8px 16px;
        font-size: 14px;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="{{ route('welcome') }}">
        <img src="{{ asset('gambar/frame.png') }}" alt="Logo" width="57" class="me-2">
        <span style="font-weight: bold; font-size: 24px;">StudentCare</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item me-2">
            <a href="{{ route('login') }}" class="btn btn-auth">Login</a>
          </li>
          <li class="nav-item">
            <a href="{{ route('register') }}" class="btn btn-auth">Daftar Sekarang</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Main -->
  <main>
    <div class="login-container">
      <h2>Verifikasi Email Anda</h2>

      <div class="text-description">
        {{ __('Terima kasih telah mendaftar! Sebelum memulai, mohon verifikasi alamat email Anda dengan mengklik tautan yang kami kirimkan ke email Anda. Jika Anda tidak menerima email tersebut, kami akan dengan senang hati mengirimkan yang lain.') }}
      </div>

      @if (session('status') == 'verification-link-sent')
        <div class="alert-success">
          {{ __('Tautan verifikasi baru telah dikirim ke alamat email yang Anda berikan saat pendaftaran.') }}
        </div>
      @endif

      <div class="mt-4 d-flex flex-column">
        <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
          @csrf
          <button type="submit" class="btn">
            {{ __('Kirim Ulang Email Verifikasi') }}
          </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="logout-link">
            {{ __('Keluar') }}
          </button>
        </form>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer>
    <div class="footer-content">
      <h3>StudentCare</h3>
      <p>© 2025 StudentCare. All rights reserved.</p>
    </div>
  </footer>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>