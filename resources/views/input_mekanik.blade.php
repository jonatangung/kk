@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Input Mekanik</h1>

    <div class="card">
        <div class="card-body">
            <form action="/aksi_tkry" method="POST" class="no-print">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Nama Mekanik:</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">No HP:</label>
                    <input type="text" name="no_hp" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Spesialisasi:</label>
                    <input type="text" name="spesialisasi" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary px-4">Simpan</button>
                <a href="/mekanik" class="btn btn-secondary px-4">Kembali</a>
            </form>
        </div>
    </div>

@endsection
