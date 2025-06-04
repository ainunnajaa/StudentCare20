<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Password - StudentCare</title>

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

    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 10px;
      border: 1px solid #ccc;
      font-size: 16px;
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

    .signup {
      text-align: center;
      margin-top: 15px;
    }

    .signup a {
      color: #d23669;
      text-decoration: none;
      font-weight: bold;
    }

    .signup a:hover {
      text-decoration: underline;
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
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #ff9a9e 0%, #ff9a9e 100%); box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); padding: 20px 40px;">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="{{ route('welcome') }}">
        <img src="{{ asset('gambar/frame.png') }}" alt="Logo" width="57" class="me-2">
        <span style="font-weight: bold; font-size: 24px;">StudentCare</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
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
      <h2>Reset Password</h2>

      @if ($errors->any())
          <div class="alert alert-danger">
              <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <input type="email" name="email" placeholder="Email" value="{{ old('email', $request->email) }}" required>

        <!-- New Password -->
        <input type="password" name="password" placeholder="Password Baru" required>

        <!-- Confirm Password -->
        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password Baru" required>

        <!-- Submit -->
        <button class="btn" type="submit">Reset Password</button>
      </form>

      <div class="signup">
        <p>Ingat passwordmu? <a href="{{ route('login') }}">Login Sekarang</a></p>
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

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
