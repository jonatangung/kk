<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title><?php echo $dataSetting['nama_usaha']; ?></title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo $dataSetting['ikon_url']; ?>" rel="icon">
  <link href="<?php echo $dataSetting['ikon_url']; ?>" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
  <style>
    @media print {
      #header, #sidebar, .footer, .no-print, .back-to-top {
        display: none !important;
      }
      #main.main {
        margin-left: 0 !important;
        padding: 20px !important;
      }
      .card {
        box-shadow: none !important;
        border: 1px solid #000 !important;
      }
    }
  </style>
</head>

<body>
  {{-- Header atas: logo, tombol sidebar, dan menu profil --}}
  <?php
      //----- Foto user diambil dari session; kosong -> pakai gambar default
      $fotoUrl = asset('assets/img/profile-img.jpg');
      if (session('foto') != null && session('foto') != '' && file_exists(public_path('uploads/' . session('foto')))) {
          $fotoUrl = asset('uploads/' . session('foto'));
      }
  ?>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="/home" class="logo d-flex align-items-center">
        <img src="<?php echo $dataSetting['logo_url']; ?>" alt="" style="height: 32px; width: auto; margin-right: 10px;">
        <span class="d-none d-lg-block" style="line-height: 1.3;">
          <span style="font-size: 1rem; font-weight: 700; display: block; letter-spacing: 0.5px;"><?php echo $dataSetting['nama_usaha']; ?></span>
        </span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
        <li class="nav-item dropdown pe-3">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="{{ $fotoUrl }}" alt="Profile" class="rounded-circle border border-1 border-warning p-0">
            <span class="d-none d-md-block dropdown-toggle ps-2 text-white">{{ session('u', 'Pengguna') }}</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
          <li class="dropdown-header d-flex align-items-center text-start">
              <img src="{{ $fotoUrl }}" alt="Profile" class="rounded-circle me-2" style="width: 45px; height: 45px; object-fit: cover;">
              <div>
                <h6 class="mb-0">{{ session('u', 'Pengguna') }}</h6>
                <span>Akun Pengguna</span>
              </div>
          </li>

              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="/profil">
                <i class="bi bi-person"></i>
                <span>Profil Saya</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="/logout">
                <i class="bi bi-box-arrow-right"></i>
                <span>Keluar</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </nav><!-- End Icons Navigation -->
  </header><!-- End Header -->
