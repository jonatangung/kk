@extends('template')
@section('content')

<h1 class="no-print">Dashboard Bengkel Motor</h1>
<p class="text-muted">Selamat datang, {{ session('u') }}</p>

<div class="row no-print mb-4">
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
    <div class="col-md-6 col-xl-3 mb-3">
        <a href="/karyawan" class="text-decoration-none">
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
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-car-front fs-1 text-primary"></i>
                <h5 class="mt-2">Data Kendaraan</h5>
                <p class="small text-muted mb-0">Kelola data kendaraan</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-wrench-adjustable fs-1 text-primary"></i>
                <h5 class="mt-2">Data Jasa Servis</h5>
                <p class="small text-muted mb-0">Kelola jenis dan harga jasa</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-box-seam fs-1 text-primary"></i>
                <h5 class="mt-2">Data Sparepart</h5>
                <p class="small text-muted mb-0">Kelola stok sparepart</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-truck fs-1 text-primary"></i>
                <h5 class="mt-2">Data Supplier</h5>
                <p class="small text-muted mb-0">Kelola data supplier</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-cart-check fs-1 text-primary"></i>
                <h5 class="mt-2">Transaksi Servis</h5>
                <p class="small text-muted mb-0">Kelola transaksi bengkel</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="bi bi-cash-stack fs-1 text-primary"></i>
                <h5 class="mt-2">Pembayaran</h5>
                <p class="small text-muted mb-0">Kelola pembayaran servis</p>
            </div>
        </div>
    </div>
</div>




<br>



<a href="/logout"><button class="btn btn-secondary">sayonara</button></a>
@endsection