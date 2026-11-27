<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Data Masuk - <?php echo $dataSetting['nama_usaha']; ?></title>
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
</head>

<body>

  <!-- Main content -->
  <main class="main">

    <div class="pagetitle">
      <h1>Data Masuk</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Data Masuk</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Form Data Masuk Barang</h5>

              @if ($barangList->isEmpty())
                <div class="alert alert-warning">
                  <i class="bi bi-exclamation-triangle me-2"></i>
                  Belum ada data barang. Silakan tambahkan barang terlebih dahulu.
                </div>
              @else
                <form action="{{ route('data-masuk.simpan') }}" method="POST" class="row g-3">
                  @csrf

                  {{-- Nama Barang --}}
                  <div class="col-12">
                    <label for="supplier_id" class="form-label">Nama Barang</label>
                    <select class="form-select" id="supplier_id" name="supplier_id" required>
                      <option value="">Pilih Barang</option>
                      @foreach ($barangList as $barang)
                        <option value="{{ $barang->id }}">
                          {{ $barang->nama_barang }} ({{ $barang->nama_supplier }})
                        </option>
                      @endforeach
                    </select>
                  </div>

                  {{-- Stok Masuk --}}
                  <div class="col-12">
                    <label for="stok_masuk" class="form-label">Stok Masuk</label>
                    <input type="number" class="form-control" id="stok_masuk" name="stok_masuk" min="1" required placeholder="Masukkan jumlah stok">
                  </div>

                  {{-- Harga --}}
                  <div class="col-12">
                    <label for="harga" class="form-label">Harga</label>
                    <input type="number" class="form-control" id="harga" name="harga" min="0" step="0.01" required placeholder="Masukkan harga">
                  </div>

                  {{-- Tanggal Masuk --}}
                  <div class="col-12">
                    <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                    <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="{{ $today }}" required>
                  </div>

                  <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                      <i class="bi bi-save me-2"></i> Simpan Data Masuk
                    </button>
                  </div>
                </form>
              @endif

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/quill/quill.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
  <script src="{{ asset('assets/vendor/chart.js/chart.umd.js') }}"></script>

  <!-- Template Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

</body>

</html>
