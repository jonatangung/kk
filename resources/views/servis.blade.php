@extends('template')
@section('content')
<h1>Transaksi Servis</h1>
<a href="/master/servis/create" class="btn btn-secondary mb-3">Tambah Servis</a>
<div class="card mt-3">
    <div class="card-header"><h5 class="card-title mb-0">Transaksi Servis</h5></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead><tr><th>No</th><th>Kode Servis</th><th>Kendaraan ID</th><th>Tanggal</th><th>Status</th></tr></thead>
            <tbody>
            <?php
            $no = 1;
            foreach ($rows as $value) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $value->kode_servis ?></td>
                    <td><?= $value->kendaraan_id ?></td>
                    <td><?= $value->tanggal_masuk ?></td>
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
