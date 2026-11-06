@extends('template')
@section('content')

    <h1 class="mb-4 fw-bold">Input Mekanik</h1>

    <form action="/aksi_tkry" method="POST" class="no-print" style="max-width: 500px;">
        @csrf

        <label class="fw-semibold">Nama Mekanik:</label>
        <input type="text" name="nama" class="form-control" required>
        <br>

        <label class="fw-semibold">No HP:</label>
        <input type="text" name="no_hp" class="form-control">
        <br>

        <label class="fw-semibold">Spesialisasi:</label>
        <input type="text" name="spesialisasi" class="form-control">
        <br>

        <button type="submit" class="btn btn-primary px-4">Simpan</button>
        <a href="/home" class="btn btn-secondary px-4">Kembali</a>
        
    </form>

@endsection
