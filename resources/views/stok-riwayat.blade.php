@extends('template')
@section('content')
<h1>Riwayat Stok</h1>
<div class="card mt-3">
    <div class="card-header"><h5 class="card-title mb-0">Stok Riwayat</h5></div>
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Barang</th>
                    <th>Aktivitas</th>
                    <th>Jumlah</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ date('d/m/Y H:i', strtotime($row->tanggal)) }}</td>
                        <td>{{ $row->nama_sparepart }}</td>
                        <td>{{ $row->aktivitas }}</td>
                        <td class="{{ $row->aktivitas === 'Masuk' ? 'text-success' : 'text-danger' }}">
                            {{ $row->aktivitas === 'Masuk' ? '+' : '-' }}{{ $row->jumlah }}
                        </td>
                        <td>{{ $row->keterangan ?: '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">Belum ada riwayat stok.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
