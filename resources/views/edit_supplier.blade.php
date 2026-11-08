@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Edit Supplier</h1>

    <div class="card">
        <div class="card-body">
            <form action="/edit_supplier_aksi/{{ $row->id }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Nama Supplier</label>
                    <input type="text" name="nama_supplier" value="{{ $row->nama_supplier }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Kontak Person</label>
                    <input type="text" name="kontak_person" value="{{ $row->kontak_person }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">No HP</label>
                    <input type="text" name="no_hp" value="{{ $row->no_hp }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Email</label>
                    <input type="email" name="email" value="{{ $row->email }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Alamat</label>
                    <textarea name="alamat" class="form-control">{{ $row->alamat }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Nama Barang</label>
                    <input type="text" name="nama_barang" value="{{ $row->nama_barang }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Stok</label>
                    <input type="number" name="stok" value="{{ $row->stok }}" min="0" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Harga</label>
                    <input type="number" name="harga" value="{{ $row->harga }}" min="0" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Tanggal Masuk</label>
                    <input type="date" name="tanggal_masuk" value="{{ $row->tanggal_masuk }}" class="form-control">
                </div>

                <button class="btn btn-warning" type="submit">Perbarui</button>
                <a href="/supplier" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
