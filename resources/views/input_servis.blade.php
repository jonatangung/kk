@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Tambah Servis</h1>

    <div class="card">
        <div class="card-body">
            <form action="/tambah_servis_aksi" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Pelanggan</label>
                    <select name="pelanggan_id" class="form-control" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach ($pelanggan as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Kendaraan</label>
                    <select name="kendaraan_id" class="form-control" required>
                        <option value="">-- Pilih Kendaraan --</option>
                        @foreach ($kendaraan as $item)
                            <option value="{{ $item->id }}">{{ $item->no_polisi }} - {{ $item->merk }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Mekanik</label>
                    <select name="mekanik_id" class="form-control" required>
                        <option value="">-- Pilih Mekanik (Opsional) --</option>
                        @foreach ($mekanik as $item)
                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Keluhan</label>
                    <textarea name="keluhan" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Jasa Servis</label>
                    @foreach ($jasa as $item)
                        <div class="d-flex align-items-center gap-2 border rounded p-2 mb-2">
                            <input type="checkbox" name="jasa_servis_id[]" value="{{ $item->id }}" id="jasa{{ $item->id }}">
                            <label for="jasa{{ $item->id }}" class="mb-0 flex-grow-1">
                                {{ $item->nama_jasa }} - Rp{{ number_format($item->harga, 0, ',', '.') }}
                            </label>
                            <input type="number" name="jumlah_jasa[{{ $item->id }}]" value="1" min="1" class="form-control" style="width: 90px;" aria-label="Jumlah {{ $item->nama_jasa }}">
                        </div>
                    @endforeach
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="form-control" required>
                        <option value="">-- Pilih Metode Pembayaran --</option>
                        <option value="tunai">Tunai</option>
                        <option value="transfer">Transfer</option>
                        <option value="qris">QRIS</option>
                        <option value="debit">Debit</option>
                        <option value="kredit">Kredit</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Status</label>
                    <select name="status" class="form-control" required>
                        <option value="" selected>-- Pilih Status --</option>
                        <option value="antri">Antri</option>
                        <option value="dikerjakan">Dikerjakan</option>
                        <option value="selesai">Selesai</option>
                        <option value="diambil">Diambil</option>
                        <option value="batal">Batal</option>
                    </select>
                </div>

                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="/servis" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
