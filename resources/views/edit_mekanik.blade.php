@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Edit Mekanik</h1>

    <div class="card">
        <div class="card-body">
            <form action="/edit_mekanik_aksi/{{ $row->id }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Nama</label>
                    <input type="text" name="nama" value="{{ $row->nama }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">No HP</label>
                    <input type="text" name="no_hp" value="{{ $row->no_hp }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Spesialisasi</label>
                    <input type="text" name="spesialisasi" value="{{ $row->spesialisasi }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="aktif" @selected($row->status == 'aktif')>Aktif</option>
                        <option value="nonaktif" @selected($row->status == 'nonaktif')>Nonaktif</option>
                    </select>
                </div>

                <button class="btn btn-warning" type="submit">Perbarui</button>
                <a href="/mekanik" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
