@extends('template')
@section('content')
<h1>Stok Masuk</h1>
<a href="/master/stok_masuk/create" class="btn btn-secondary mb-3">Tambah Stok Masuk</a>
<div class="card mt-3">
    <div class="card-header"><h5 class="card-title mb-0">Stok Masuk</h5></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead><tr><th>No</th><th>Sparepart ID</th><th>Tanggal</th><th>Jumlah</th><th>Keterangan</th></tr></thead>
            <tbody>
            <?php
            $no = 1;
            foreach ($rows as $value) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $value->sparepart_id ?></td>
                    <td><?= $value->tanggal ?></td>
                    <td><?= $value->jumlah ?></td>
                    <td><?= $value->keterangan ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
@endsection
