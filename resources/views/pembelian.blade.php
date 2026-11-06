@extends('template')
@section('content')
<h1>Pembelian Sparepart</h1>
<a href="/master/pembelian/create" class="btn btn-secondary mb-3">Tambah Pembelian</a>
<div class="card mt-3">
    <div class="card-header"><h5 class="card-title mb-0">Pembelian Sparepart</h5></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead><tr><th>No</th><th>Supplier ID</th><th>Tanggal</th><th>Total</th><th>Status</th></tr></thead>
            <tbody>
            <?php
            $no = 1;
            foreach ($rows as $value) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $value->supplier_id ?></td>
                    <td><?= $value->tanggal ?></td>
                    <td><?= $value->total ?></td>
                    <td><?= $value->status ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
@endsection
