@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Edit Pelanggan</h1>

    <div class="card">
        <div class="card-body">
            <form action="/edit_pelanggan_aksi/{{ $row->id }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Kode Pelanggan</label>
                    <input type="text" name="kode_pelanggan" value="{{ $row->kode_pelanggan }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Nama</label>
                    <input type="text" name="nama" value="{{ $row->nama }}" class="form-control" required>
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
                    <input type="text" name="alamat" value="{{ $row->alamat }}" class="form-control">
                </div>

                <button class="btn btn-warning" type="submit">Perbarui</button>
                <a href="/pelanggan" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
