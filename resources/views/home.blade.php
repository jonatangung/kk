@extends('template')

@section('content')
{{-- Halaman dashboard. Kartu menu mengikuti sidebar (menu.blade.php) dan hak akses role (App\Support\RolePermission) --}}

    <?php
        $role = session('role');
        $canView = fn (string $resource) => \App\Support\RolePermission::boleh('view:' . $resource, $role);
    ?>
    <div class="pagetitle no-print">
        <h1 style="background: linear-gradient(135deg, #FFD700 0%, #FFB300 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent;">Dashboard <?php echo $dataSetting['nama_usaha']; ?></h1>
    </div>
    <div class="d-inline-block rounded-3 mb-4 px-3 py-2 shadow-sm" style="background: #ffffff; border: 1px solid #bdbdbd; width: fit-content;">
        <span class="d-inline-flex align-items-center gap-2" style="color: #212529; font-weight: 600; white-space: nowrap;">
            <i class="bi bi-wrench-adjustable text-warning"></i>
            Selamat datang, <span style="text-transform: uppercase;">{{ session('u', '') }}</span> ({{ $role }})
        </span>
    </div>

    {{-- Informasi Nama Pemilik dan Alamat --}}
    <div class="card shadow-sm mb-4 no-print" style="border-left: 4px solid #FFD700;">
        <div class="card-body">
            <h5 class="card-title mb-2 text-warning">
                <i class="bi bi-building"></i> Informasi Usaha
            </h5>
            <p class="card-text mb-1">
                <strong>Nama Pemilik:</strong> <?php echo $dataSetting['nama_owner']; ?>
            </p>
            <p class="card-text mb-0">
                <strong>Alamat:</strong> <?php echo $dataSetting['alamat']; ?>
            </p>
        </div>
    </div>

    {{-- Kartu menu cepat, tiap kartu hanya tampil sesuai hak akses role user --}}
    <div class="row no-print mb-4">
        <?php if ($canView('pelanggan')) { ?>
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/pelanggan" class="text-decoration-none">
                <div class="card shadow-sm border-0 border-top border-warning border-3 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-person fs-1 text-warning"></i>
                        <h5 class="mt-2 text-dark">Data Pelanggan</h5>
                        <p class="small text-muted mb-0">Kelola data pelanggan</p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>

        <?php if ($canView('kendaraan')) { ?>
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/kendaraan" class="text-decoration-none">
                <div class="card shadow-sm border-0 border-top border-warning border-3 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-car-front fs-1 text-warning"></i>
                        <h5 class="mt-2 text-dark">Data Kendaraan</h5>
                        <p class="small text-muted mb-0">Kelola data kendaraan</p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>

        <?php if ($canView('mekanik')) { ?>
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/mekanik" class="text-decoration-none">
                <div class="card shadow-sm border-0 border-top border-warning border-3 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-person-badge fs-1 text-warning"></i>
                        <h5 class="mt-2 text-dark">Data Mekanik</h5>
                        <p class="small text-muted mb-0">Kelola data Mekanik</p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>

        <?php if ($canView('jasa_servis')) { ?>
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/jasa-servis" class="text-decoration-none">
                <div class="card shadow-sm border-0 border-top border-warning border-3 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-wrench-adjustable fs-1 text-warning"></i>
                        <h5 class="mt-2 text-dark">Data Jasa Servis</h5>
                        <p class="small text-muted mb-0">Kelola jenis dan harga jasa</p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>

        <?php if ($canView('supplier')) { ?>
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/supplier" class="text-decoration-none">
                <div class="card shadow-sm border-0 border-top border-warning border-3 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-truck fs-1 text-warning"></i>
                        <h5 class="mt-2 text-dark">Data Supplier</h5>
                        <p class="small text-muted mb-0">Kelola data supplier</p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>

        <?php if ($canView('servis')) { ?>
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/servis" class="text-decoration-none">
                <div class="card shadow-sm border-0 border-top border-warning border-3 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-cart-check fs-1 text-warning"></i>
                        <h5 class="mt-2 text-dark">Transaksi Servis</h5>
                        <p class="small text-muted mb-0">Kelola transaksi bengkel</p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>

        <?php if ($canView('pembayaran')) { ?>
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/pembayaran" class="text-decoration-none">
                <div class="card shadow-sm border-0 border-top border-warning border-3 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-cash-stack fs-1 text-warning"></i>
                        <h5 class="mt-2 text-dark">Pembayaran</h5>
                        <p class="small text-muted mb-0">Kelola pembayaran servis</p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>

        <?php if ($canView('laporan_servis')) { ?>
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/laporan-servis" class="text-decoration-none">
                <div class="card shadow-sm border-0 border-top border-warning border-3 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-file-earmark-text fs-1 text-warning"></i>
                        <h5 class="mt-2 text-dark">Laporan Servis</h5>
                        <p class="small text-muted mb-0">Lihat laporan transaksi servis</p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>

        <?php if ($canView('laporan_pendapatan')) { ?>
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/laporan-pendapatan" class="text-decoration-none">
                <div class="card shadow-sm border-0 border-top border-warning border-3 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-bar-chart fs-1 text-warning"></i>
                        <h5 class="mt-2 text-dark">Laporan Pendapatan</h5>
                        <p class="small text-muted mb-0">Lihat laporan pendapatan</p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>

        <?php if ($canView('stok_barang')) { ?>
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/stok-barang" class="text-decoration-none">
                <div class="card shadow-sm border-0 border-top border-warning border-3 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-box-seam fs-1 text-warning"></i>
                        <h5 class="mt-2 text-dark">Stok Barang</h5>
                        <p class="small text-muted mb-0">Kelola stok barang</p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>

        <?php if ($canView('pengguna')) { ?>
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/pengguna" class="text-decoration-none">
                <div class="card shadow-sm border-0 border-top border-warning border-3 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-people fs-1 text-warning"></i>
                        <h5 class="mt-2 text-dark">Manajemen Pengguna</h5>
                        <p class="small text-muted mb-0">Kelola akun pengguna</p>
                    </div>
                </div>
            </a>
        </div>
        <?php } ?>

        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/profil" class="text-decoration-none">
                <div class="card shadow-sm border-0 border-top border-warning border-3 h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-gear fs-1 text-warning"></i>
                        <h5 class="mt-2 text-dark">Pengaturan Profil</h5>
                        <p class="small text-muted mb-0">Kelola profil akun</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

@endsection
