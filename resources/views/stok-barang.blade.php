@extends('template')

@section('content')

    <h1 class="mb-3">Stok Barang</h1>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2 no-print">
        <a href="/input_stok_barang" class="btn btn-primary">Kelola Stok</a>
        <div>
            <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()">Print Window</button>
            <a href="/stok-barang/pdf" target="_blank" class="btn btn-danger btn-sm">Download PDF</a>
            <a href="/stok-barang/excel" class="btn btn-success btn-sm">Export Excel</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <h5 class="card-title">Stok Barang</h5>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Supplier</th>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Stok Sekarang</th>
                        <th>Stok Masuk</th>
                        <th>Tanggal Masuk</th>
                        <th>Stok Keluar</th>
                        <th>Tanggal Keluar</th>
                        <th>Harga Jual</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($rows as $row)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $row->nama_supplier }}</td>
                            <td>{{ $row->nama_barang ?: '-' }}</td>
                            <td>Rp{{ number_format($row->harga, 0, ',', '.') }}</td>
                            <td>{{ $row->stok }}</td>
                            <td>{{ $row->stok_masuk }}</td>
                            <td>{{ $row->tanggal_masuk }}</td>
                            <td>{{ $row->stok_keluar }}</td>
                            <td>{{ $row->tanggal_keluar }}</td>
                            <td>Rp{{ number_format($row->harga_jual ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
