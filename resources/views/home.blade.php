@extends('template')

@section('content')

    @php $role = session('role'); @endphp
    <h1 class="no-print mb-1">Dashboard Bengkel Motor</h1>
    <p class="text-muted mb-4">Selamat datang, {{ session('u') }} ({{ ucfirst($role ?? '-') }})</p>

    <div class="row no-print mb-4">
        @if (in_array($role, ['owner', 'kasir']))
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/pelanggan" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-person fs-1 text-primary"></i>
                        <h5 class="mt-2 text-dark">Data Pelanggan</h5>
                        <p class="small text-muted mb-0">Kelola data pelanggan</p>
                    </div>
                </div>
            </a>
        </div>
        @endif

        @if (in_array($role, ['owner', 'admin']))
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/mekanik" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-person-badge fs-1 text-primary"></i>
                        <h5 class="mt-2 text-dark">Data Mekanik</h5>
                        <p class="small text-muted mb-0">Kelola data Mekanik</p>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/jasa-servis" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-wrench-adjustable fs-1 text-primary"></i>
                        <h5 class="mt-2 text-dark">Data Jasa Servis</h5>
                        <p class="small text-muted mb-0">Kelola jenis dan harga jasa</p>
                    </div>
                </div>
            </a>
        </div>
        @endif

        @if ($role === 'owner')
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/supplier" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-truck fs-1 text-primary"></i>
                        <h5 class="mt-2 text-dark">Data Supplier</h5>
                        <p class="small text-muted mb-0">Kelola data supplier</p>
                    </div>
                </div>
            </a>
        </div>
        @endif

        @if (in_array($role, ['owner', 'kasir']))
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/servis" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-cart-check fs-1 text-primary"></i>
                        <h5 class="mt-2 text-dark">Transaksi Servis</h5>
                        <p class="small text-muted mb-0">Kelola transaksi bengkel</p>
                    </div>
                </div>
            </a>
        </div>
        @endif

        @if ($role === 'owner')
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/pembayaran" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-cash-stack fs-1 text-primary"></i>
                        <h5 class="mt-2 text-dark">Pembayaran</h5>
                        <p class="small text-muted mb-0">Kelola pembayaran servis</p>
                    </div>
                </div>
            </a>
        </div>
        @endif

        @if (in_array($role, ['owner', 'karyawan']))
        <div class="col-md-6 col-xl-3 mb-3">
            <a href="/kendaraan" class="text-decoration-none">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <i class="bi bi-car-front fs-1 text-primary"></i>
                        <h5 class="mt-2 text-dark">Data Kendaraan</h5>
                        <p class="small text-muted mb-0">Kelola data kendaraan</p>
                    </div>
                </div>
            </a>
        </div>
        @endif
    </div>

 

@endsection
