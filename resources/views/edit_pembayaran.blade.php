@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Edit Pembayaran</h1>

    <div class="card">
        <div class="card-body">
            <form action="/edit_pembayaran_aksi/{{ $row->id }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">No Pembayaran</label>
                    <input type="text" name="no_pembayaran" value="{{ $row->no_pembayaran }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Servis</label>
                    <select name="servis_id" class="form-control">
                        @foreach ($servis as $item)
                            <option value="{{ $item->id }}" @selected($row->servis_id == $item->id)>
                                {{ $item->no_servis }} - {{ $item->keluhan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ $row->tanggal ? date('Y-m-d', strtotime($row->tanggal)) : '' }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Metode</label>
                    <select name="metode" class="form-control">
                        @foreach (['tunai' => 'Tunai', 'transfer' => 'Transfer', 'qris' => 'QRIS', 'debit' => 'Debit', 'kredit' => 'Kredit'] as $value => $label)
                            <option value="{{ $value }}" @selected($row->metode == $value)>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                @if ($detailJasa->isNotEmpty())
                    <div class="mb-3">
                        <label class="fw-semibold">Jasa Servis yang Dipilih</label>
                        <table class="table table-sm table-bordered mb-1">
                            <thead class="table-light">
                                <tr>
                                    <th>Jasa</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($detailJasa as $jasa)
                                    <tr>
                                        <td>{{ $jasa->nama_jasa }}</td>
                                        <td class="text-center">{{ $jasa->jumlah }}</td>
                                        <td class="text-end">Rp{{ number_format($jasa->harga, 0, ',', '.') }}</td>
                                        <td class="text-end">Rp{{ number_format($jasa->jumlah * $jasa->harga, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <small class="text-muted">Jumlah bayar dihitung otomatis dari total jasa di atas. Ubah jasa melalui menu Servis.</small>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="fw-semibold">Jumlah Bayar</label>
                    <input type="number" name="jumlah_bayar" value="{{ $row->jumlah_bayar }}" class="form-control" @if ($detailJasa->isNotEmpty()) readonly @endif>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">No Referensi</label>
                    <input type="text" name="no_referensi" value="{{ $row->no_referensi }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Catatan</label>
                    <textarea name="catatan" class="form-control">{{ $row->catatan }}</textarea>
                </div>

                <button class="btn btn-warning" type="submit">Perbarui</button>
                <a href="/pembayaran" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
