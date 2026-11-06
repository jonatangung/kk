@extends('template')
@section('content')
<h1>Laporan Persediaan</h1>
<div class="row mt-3">
    <div class="col-md-4 mb-3"><div class="card"><div class="card-body"><small class="text-muted">Total Jenis Sparepart</small><h3>{{ $summary['jenis'] }}</h3></div></div></div>
    <div class="col-md-4 mb-3"><div class="card"><div class="card-body"><small class="text-muted">Total Seluruh Stok</small><h3>{{ $summary['total_stok'] }}</h3></div></div></div>
    <div class="col-md-4 mb-3"><div class="card"><div class="card-body"><small class="text-muted">Nilai Persediaan</small><h3>Rp {{ number_format($summary['nilai'], 0, ',', '.') }}</h3></div></div></div>
    <div class="col-md-6 mb-3"><div class="card"><div class="card-body"><small class="text-muted">Stok Hampir Habis</small><h3>{{ $summary['hampir_habis'] }}</h3></div></div></div>
    <div class="col-md-6 mb-3"><div class="card"><div class="card-body"><small class="text-muted">Stok Kosong</small><h3>{{ $summary['kosong'] }}</h3></div></div></div>
</div>

<div class="card">
    <div class="card-header"><h5 class="card-title mb-0">Stok Persediaan</h5></div>
        <table class="table table-bordered table-striped mb-0">
            <thead><tr><th>No</th><th>Nama Sparepart</th><th>Stok</th><th>Minimum</th><th>Kondisi</th></tr></thead>
            <tbody>
                @forelse ($rows as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->nama_sparepart }}</td>
                        <td>{{ $row->stok }}</td>
                        <td>{{ $row->stok_minimum }}</td>
                        <td>
                            @if ($row->stok == 0) Kosong
                            @elseif ($row->stok <= $row->stok_minimum) Hampir habis
                            @else Aman
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">Belum ada data persediaan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
