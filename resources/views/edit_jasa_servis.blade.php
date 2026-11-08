@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Edit Jasa Servis</h1>

    <div class="card">
        <div class="card-body">
            <form action="/edit_jasa_servis_aksi/{{ $row->id }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Kode Jasa</label>
                    <input type="text" name="kode_jasa" value="{{ $row->kode_jasa }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Nama Jasa</label>
                    <input type="text" name="nama_jasa" value="{{ $row->nama_jasa }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Harga</label>
                    <input type="number" name="harga" value="{{ $row->harga }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Estimasi Menit</label>
                    <input type="number" name="estimasi_menit" value="{{ $row->estimasi_menit }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control">{{ $row->deskripsi }}</textarea>
                </div>

                <button class="btn btn-warning" type="submit">Perbarui</button>
                <a href="/jasa-servis" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
