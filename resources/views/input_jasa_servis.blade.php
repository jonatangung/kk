@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Tambah Jasa Servis</h1>

    <div class="card">
        <div class="card-body">
            <form action="/tambah_jasa_servis_aksi" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Nama Jasa</label>
                    <input type="text" name="nama_jasa" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Harga</label>
                    <input type="number" name="harga" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Estimasi Menit</label>
                    <input type="number" name="estimasi_menit" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control"></textarea>
                </div>

                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="/jasa-servis" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
