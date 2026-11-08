@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Tambah Kendaraan</h1>

    <div class="card">
        <div class="card-body">
            <form action="/tambah_kendaraan_aksi" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Pelanggan</label>
                    <select name="pelanggan_id" class="form-control" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach ($pelanggan as $item)
                            <option value="{{ $item->id }}" @selected(old('pelanggan_id') == $item->id)>
                                {{ $item->kode_pelanggan }} - {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">No Polisi</label>
                    <input type="text" name="no_polisi" class="form-control" value="{{ old('no_polisi') }}" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Merk</label>
                    <input type="text" name="merk" class="form-control" value="{{ old('merk') }}" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Model</label>
                    <input type="text" name="model" class="form-control" value="{{ old('model') }}" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Tahun</label>
                    <input type="number" name="tahun" class="form-control" value="{{ old('tahun') }}">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Warna</label>
                    <input type="text" name="warna" class="form-control" value="{{ old('warna') }}">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">No Rangka</label>
                    <input type="text" name="no_rangka" class="form-control" value="{{ old('no_rangka') }}">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">No Mesin</label>
                    <input type="text" name="no_mesin" class="form-control" value="{{ old('no_mesin') }}">
                </div>

                <button type="submit" class="btn btn-primary px-4">Simpan</button>
                <a href="/kendaraan" class="btn btn-secondary px-4">Kembali</a>
            </form>
        </div>
    </div>

@endsection
