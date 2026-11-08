@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Input Pelanggan</h1>

    <div class="card">
        <div class="card-body">
            <form action="/aksi_tplg" method="POST" class="no-print">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Nama Pelanggan:</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Alamat:</label>
                    <input type="text" name="alamat" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Email:</label>
                    <input type="text" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">No HP:</label>
                    <input type="text" name="no_hp" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary px-4">Simpan</button>
                <a href="/pelanggan" class="btn btn-secondary px-4">Kembali</a>
            </form>
        </div>
    </div>

@endsection
