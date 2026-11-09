@extends('template')

@section('content')

    <h1 class="mb-3">Data Supplier</h1>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2 no-print">
        <a href="/tambah_supplier" class="btn btn-secondary">Tambah Supplier</a>
        <div>
            <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()">Print Window</button>
            <a href="/supplier/pdf" target="_blank" class="btn btn-danger btn-sm">Download PDF</a>
            <a href="/supplier/excel" class="btn btn-success btn-sm">Export Excel</a>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body table-responsive">
            <h5 class="card-title">Data Supplier</h5>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Supplier / PT</th>
                        <th>Nama Barang</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Tanggal Masuk</th>
                        <th>No HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($rows as $value)
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->nama_supplier ?></td>
                            <td><?= $value->nama_barang ?: '-' ?></td>
                            <td><?= $value->stok ?></td>
                            <td>Rp<?= number_format($value->harga, 0, ',', '.') ?></td>
                            <td><?= $value->tanggal_masuk ?: '-' ?></td>
                            <td><?= $value->no_hp ?></td>
                            <td>
                                <a href="/edit_supplier/<?= $value->id ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form action="/hapus_supplier/<?= $value->id ?>" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
