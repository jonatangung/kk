@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Tambah Supplier</h1>

    <div class="card">
        <div class="card-body">
            <form action="/tambah_supplier_aksi" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Nama Supplier</label>
                    <input type="text" name="nama_supplier" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Stok</label>
                    <input type="number" name="stok" class="form-control" value="0" min="0" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Harga</label>
                    <input type="number" name="harga" class="form-control" value="0" min="0" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Kontak Person</label>
                    <input type="text" name="kontak_person" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">No HP</label>
                    <input type="text" name="no_hp" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Alamat</label>
                    <textarea name="alamat" class="form-control"></textarea>
                </div>

                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="/supplier" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
