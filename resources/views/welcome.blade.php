<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>StudentCare</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet"/>
  
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- AOS CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <style>
    html {
      scroll-behavior: smooth;
    }
    
    html, body {
      height: 100%;
      margin: 0;
      font-family: 'Poppins', sans-serif;
      background-color: #fff5f7;
    }

    body {
      display: flex;
      flex-direction: column;
    }

    main {
      flex: 1;
    }

    .section-box {
      background-color: white;
      padding: 40px 5%;
      margin: 40px 0;
      border-radius: 12px;
      border: 1px solid #fff;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }

    .hero {
      background: linear-gradient(135deg, #fbabae 0%, #fad0c4 100%);
      color: white;
      padding-bottom: 0px;
      padding-top: 70px;
      padding-right: 10px;
      padding-left: 150px;
      display: flex;
      flex-direction: row;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
      border-radius: 0 0 16px 16px;
    }

    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .hero p {
      font-size: 1.2rem;
      opacity: 0.9;
      margin-bottom: 30px;
    }

    .hero img {
      width: 100%;
      max-width: 400px;
      height: auto;
      max-height: 400px;
      object-fit: contain;
    }

    .btn-konseling {
      background-color: white;
      color: #ff6b8b;
      padding: 12px 30px;
      border: none;
      border-radius: 30px;
      font-weight: bold;
      text-decoration: none;
      transition: all 0.3s ease;
      font-size: 18px;
      display: inline-block;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-konseling:hover {
      background-color: #ffe4ec;
      color: #d23669;
      transform: translateY(-2px);
    }

    @media (max-width: 768px) {
      .hero {
        text-align: center;
        padding: 30px 5%;
      }
      
      .hero h1 {
        font-size: 2.2rem;
      }
      
      .hero p {
        font-size: 1rem;
        margin-bottom: 25px;
      }
      
      .hero img {
        max-width: 280px;
        max-height: 280px;
        margin-top: 20px;
      }
      
      .text-content {
        padding-right: 0;
      }
      
      .navbar-nav {
        margin-top: 15px;
      }
      
      .btn-auth {
        padding: 8px 16px;
        font-size: 14px;
      }
      
      .btn-konseling {
        padding: 10px 25px;
        font-size: 16px;
      }
      
      .section-box {
        padding: 30px 5%;
        margin: 30px 0;
      }
      
      .article {
        min-width: 100%;
        margin-bottom: 20px;
      }
    }

    .text-content {
      flex: 1;
      min-width: 300px;
      padding-right: 40px;
    }

    .hero > div:last-child {
      flex: 1;
      min-width: 300px;
      display: flex;
      justify-content: center;
      align-items: center;
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
      font-size: 16px;
      display: inline-block;
    }

    .btn-auth:hover {
      background-color: #d23669;
      color: white;
      text-decoration: none;
    }

    .article-section {
      display: flex;
      justify-content: space-between;
      gap: 30px;
      flex-wrap: wrap;
    }

    .article {
      background-color: white;
      padding: 30px;
      flex: 1;
      min-width: 280px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
    }

    .article:hover {
      transform: translateY(-5px);
    }

    .article img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
      margin-bottom: 15px;
    }

    .article h3, .article h4 {
      color: #d23669;
      margin-bottom: 10px;
    }

    .article p {
      font-size: 1rem;
      color: #4a4a4a;
      margin-bottom: 20px;
    }

    .article a {
      color: #ff6b8b;
      text-decoration: none;
      font-weight: bold;
    }

    .article a:hover {
      text-decoration: underline;
    }

    .section-title {
      font-size: 1.5rem;
      font-weight: 600;
      color: #d23669;
      text-align: center;
      margin-top: 20px;
      margin-bottom: 30px;
    }

    footer {
      background-color: #1f1f1f;
      color: white;
      padding: 30px 20px;
      text-align: center;
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

    .old-hero {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      gap: 40px;
    }

    .old-hero-content {
      flex: 1;
      min-width: 280px;
    }

    .old-hero-content h1 {
      font-size: 2rem;
      color: #d23669;
      margin-bottom: 20px;
    }

    .fitur-list {
      list-style: none;
      padding: 0;
      margin-top: 20px;
      display: grid;
      gap: 12px;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    }

    .fitur-list li {
      background-color: #fbeef1;
      padding: 12px 16px;
      border-radius: 8px;
      font-weight: 500;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      display: flex;
      gap: 10px;
      transition: all 0.3s ease;
      transform: scale(1);
      opacity: 0.9;
    }

    .fitur-list li:hover {
      background-color: #ffe0e7;
      transform: scale(1.02);
      opacity: 1;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .fitur-list li i {
      color: #ff6b8b;
      font-size: 1.2rem;
      transition: transform 0.3s ease;
    }

    .fitur-list li:hover i {
      transform: scale(1.2);
    }

    .old-hero-image {
      flex: 1;
      display: flex;
      justify-content: center;
      align-items: center;
      position: relative;
    }

    .old-hero-image img {
      max-width: 400px;
      width: 100%;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(58, 141, 255, 0.2);
      transition: transform 0.5s ease;
      position: relative;
      z-index: 1;
    }

    .old-hero-image::before {
      content: '';
      position: absolute;
      width: 100%;
      height: 100%;
      background: radial-gradient(circle, rgba(255,107,139,0.2) 0%, rgba(255,107,139,0) 70%);
      border-radius: 15px;
      animation: pulse 4s infinite ease-in-out;
      z-index: 0;
    }

    @keyframes pulse {
      0% {
        transform: scale(1);
        opacity: 0.7;
      }
      50% {
        transform: scale(1.05);
        opacity: 0.4;
      }
      100% {
        transform: scale(1);
        opacity: 0.7;
      }
    }

    /* Feature highlight animation */
    @keyframes featureHighlight {
      0% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-5px);
      }
      100% {
        transform: translateY(0);
      }
    }
    
    .feature-highlight {
      animation: featureHighlight 2s infinite ease-in-out;
    }
    
    .feature-delay-1 {
      animation-delay: 0.2s;
    }
    
    .feature-delay-2 {
      animation-delay: 0.4s;
    }
    
    .feature-delay-3 {
      animation-delay: 0.6s;
    }
    
    .feature-delay-4 {
      animation-delay: 0.8s;
    }
    
    .feature-delay-5 {
      animation-delay: 1s;
    }

    .faq-section {
      background-color: white;
      border-radius: 12px;
      border: 1px solid #ffe4ec;
    }

    .accordion-button {
      background-color: #fff5f7;
      color: #d23669;
      font-weight: 500;
      transition: all 0.3s ease;
    }

    .accordion-button:not(.collapsed) {
      background-color: #d23669;
      color: white;
    }

    .accordion-body {
      background-color: #fff;
      color: #444;
    }
    
    /* Navbar styling - Updated to match login page */
    .navbar {
      padding: 20px 40px;
      background: linear-gradient(135deg, #ff9a9e 0%, #ff9a9e 100%) !important;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }
    
    .navbar.scrolled {
      background: rgba(255, 107, 139, 0.95) !important;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
      padding: 15px 40px;
    }
    
    .nav-link {
      color: white !important;
      font-weight: 500;
      padding: 8px 15px !important;
      transition: all 0.3s ease;
    }
    
    .nav-link:hover {
      color: #ffe4ec !important;
      transform: translateY(-2px);
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

    /* Mobile specific styles for features section */
    @media (max-width: 768px) {
      .old-hero {
        flex-direction: column;
        gap: 30px;
      }
      
      .old-hero-image {
        order: -1; /* Move image to top on mobile */
        margin-bottom: 20px;
      }
      
      .old-hero-image img {
        max-width: 100%;
        max-height: 300px;
        object-fit: contain;
      }
      
      .fitur-list {
        grid-template-columns: 1fr;
      }
      
      .old-hero-content h1 {
        font-size: 1.8rem;
        text-align: center;
      }
      
      .old-hero-content p {
        text-align: center;
      }
      
      /* Adjusted navbar padding for mobile */
      .navbar {
        padding: 15px 20px;
      }
      
      .navbar.scrolled {
        padding: 10px 20px;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar with updated padding -->
  <nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center" href="{{ route('welcome') }}">
        <img src="{{ asset('gambar/frame.png') }}" alt="Logo" width="57" class="me-2">
        <span style="font-weight: bold; font-size: 24px;">StudentCare</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="#home">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#artikel">Artikel</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#fitur">Fitur</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#faq">FAQ</a>
          </li>
        </ul>
        <div class="d-flex">
          <a href="{{ route('login') }}" class="btn-auth me-2">Login</a>
          <a href="{{ route('register') }}" class="btn-auth">Daftar Sekarang</a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <main>

    <!-- Hero Section -->
    <section class="hero" data-aos="fade-up" id="home">
      <div class="text-content" data-aos="fade-right">
        <h1>Selamat Datang di <span class="pink-text">StudentCare</span></h1>
        <p>
          Bicara adalah awal dari solusi. Yuk, mulai kenali dirimu dan cari tahu apa yang benar-benar kamu inginkan.
          <br>
          Karena kami siap mendengarkan apapun yang sedang kamu hadapi.
        </p>
        <a href="{{ route('register') }}" class="btn-konseling">Mulai Konseling</a>
      </div>
      <div data-aos="zoom-in">
        <img src="{{ asset('gambar/dokter.png') }}" alt="Dokter">
      </div>
    </section>

    <!-- Artikel Edukasi -->
    <section class="section-box" data-aos="fade-up" id="artikel">
      <h5 class="section-title">Kami Hadir untuk Membantu: Baca Ini</h5>
      <div class="article-section">
        <div class="article" data-aos="fade-up">
          <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSisEF8M3elcbq1GJvZbjGVdCvwMnFYf9sUNQ&s" alt="Bimbingan Konseling">
          <h4>Apa Itu Bimbingan Konseling? Teknik dan Fungsinya</h4>
          <a href="https://www.gramedia.com/literasi/bimbingan-konseling/" target="_blank">Baca Selengkapnya</a>
        </div>
        <div class="article" data-aos="fade-up" data-aos-delay="100">
          <img src="https://sph.edu/wp-content/uploads/2024/02/Pentingnya-Bimbingan-Konseling-1200x720.jpg" alt="Bimbingan Konseling">
          <h4>6 Alasan Pentingnya Bimbingan Konseling</h4>
          <a href="https://sph.edu/id/blog-id/pentingnya-bimbingan-konseling/" target="_blank">Baca Selengkapnya</a>
        </div>
        <div class="article" data-aos="fade-up" data-aos-delay="200">
          <img src="https://psbk.unikama.ac.id/wp-content/uploads/sites/33/2025/01/Foto-Web-100-scaled.jpg" alt="Bimbingan Konseling">
          <h4>Pengertian Bimbingan Konseling serta Manfaatnya</h4>
          <a href="https://psbk.unikama.ac.id/id/pengertian-bimbingan-konseling/" target="_blank">Baca Selengkapnya</a>
        </div>
      </div>
    </section>

    <!-- Info Kesehatan Mental -->
    <section class="section-box" data-aos="fade-up">
      <h5 class="section-title">Informasi Penting Seputar Kesehatan Mental</h5>
      <div class="article-section">
        <div class="article" data-aos="fade-left">
          <h3>Pengertian Bimbingan Konseling</h3>
          <p>Bimbingan Konseling adalah sebuah layanan yang bertujuan untuk membantu individu dalam menghadapi berbagai masalah emosional dan psikologis.</p>
          <a href="https://psbk.unikama.ac.id/id/pengertian-bimbingan-konseling/" target="_blank">Baca Selengkapnya</a>
        </div>
        <div class="article" data-aos="fade-left" data-aos-delay="100">
          <h3>Mental Health</h3>
          <p>Kesehatan mental adalah hal yang sangat penting. Cari tahu bagaimana cara menjaga dan meningkatkan kesehatan mental Anda melalui artikel ini.</p>
          <a href="https://www.halodoc.com/kesehatan/kesehatan-mental" target="_blank">Baca Selengkapnya</a>
        </div>
        <div class="article" data-aos="fade-left" data-aos-delay="200">
          <h3>Mengenal Stress</h3>
          <p>Stress adalah hal yang wajar, namun bisa menjadi masalah besar jika tidak dikelola dengan baik.</p>
          <a href="https://www.alodokter.com/stres-adalah" target="_blank">Baca Selengkapnya</a>
        </div>
      </div>
    </section>

    <!-- Fitur -->
    <section class="section-box" data-aos="fade-up" id="fitur">
      <div class="old-hero">
        <div class="old-hero-content" data-aos="fade-right">
          <h1>Fitur Platform Konseling Mahasiswa yang Efektif dan Terjadwal</h1>
          <p>StudentCare adalah platform konseling online yang dirancang untuk memudahkan mahasiswa dalam mengakses layanan bantuan psikologis dan akademik secara fleksibel.</p>
          <ul class="fitur-list">
            <li class="feature-highlight feature-delay-1" data-aos="fade-up" data-aos-delay="100">
              <i class="bi bi-calendar-check"></i> Jadwal Konseling Terjadwal
            </li>
            <li class="feature-highlight feature-delay-2" data-aos="fade-up" data-aos-delay="200">
              <i class="bi bi-whatsapp"></i> Layanan Konseling Via WhatsApp
            </li>
            <li class="feature-highlight feature-delay-3" data-aos="fade-up" data-aos-delay="300">
              <i class="bi bi-star-fill"></i> Sistem Rating Konselor
            </li>
            <li class="feature-highlight feature-delay-4" data-aos="fade-up" data-aos-delay="400">
              <i class="bi bi-journal-text"></i> Artikel Edukasi Psikologis
            </li>
            <li class="feature-highlight feature-delay-5" data-aos="fade-up" data-aos-delay="500">
              <i class="bi bi-clock-history"></i> Riwayat Konseling Terdokumentasi
            </li>
          </ul>
        </div>
        <div class="old-hero-image" data-aos="zoom-in-left">
          <img src="https://i.pinimg.com/1200x/72/3c/c9/723cc97d6e7768578cf2b56477b7d105.jpg" alt="Ilustrasi StudentCare" class="img-fluid">
        </div>
      </div>
    </section>

    <!-- FAQ -->
    <section class="section-box faq-section" data-aos="fade-up" id="faq">
      <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
      <div class="accordion mt-4" id="faqAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header" id="faq1">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse1">
              Apa itu StudentCare?
            </button>
          </h2>
          <div id="faqCollapse1" class="accordion-collapse collapse show">
            <div class="accordion-body">
              StudentCare adalah platform konseling online untuk mahasiswa agar lebih mudah mengakses layanan bantuan psikologis dan akademik.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="faq2">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse2">
              Apakah layanan ini gratis?
            </button>
          </h2>
          <div id="faqCollapse2" class="accordion-collapse collapse">
            <div class="accordion-body">
              Ya, layanan dasar seperti sesi chat dan artikel edukasi tersedia secara gratis untuk semua mahasiswa.
            </div>
          </div>
        </div>

        <div class="accordion-item">
          <h2 class="accordion-header" id="faq3">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse3">
              Bagaimana cara menjadwalkan sesi konseling?
            </button>
          </h2>
          <div id="faqCollapse3" class="accordion-collapse collapse">
            <div class="accordion-body">
              Jadwalkan konseling melalui menu "Jadwal Konseling" di platform dengan memilih waktu dan konselor yang tersedia.
            </div>
          </div>
        </div>
      </div>
    </section>

  </main>

  <!-- Footer -->
  <footer>
    <div class="footer-content">
      <h3>StudentCare</h3>
      <p>© 2025 StudentCare. All rights reserved.</p>
    </div>
  </footer>

  <!-- JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true
    });
    
    // Navbar scroll effect
    window.addEventListener('scroll', function() {
      const navbar = document.querySelector('.navbar');
      if (window.scrollY > 50) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }
    });
    
    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        
        document.querySelector(this.getAttribute('href')).scrollIntoView({
          behavior: 'smooth'
        });
      });
    });
  </script>
</body>
</html>