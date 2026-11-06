@extends('template')
@section('content')
<h1>Pembayaran</h1>
<a href="/master/pembayaran/create" class="btn btn-secondary mb-3">Tambah Pembayaran</a>
<div class="card mt-3">
    <div class="card-header"><h5 class="card-title mb-0">Pembayaran</h5></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead><tr><th>No</th><th>No Pembayaran</th><th>Servis ID</th><th>Tanggal</th><th>Jumlah Bayar</th><th>Metode</th></tr></thead>
            <tbody>
            <?php
            $no = 1;
            foreach ($rows as $value) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $value->no_pembayaran ?></td>
                    <td><?= $value->servis_id ?></td>
                    <td><?= $value->tanggal ?></td>
                    <td><?= $value->jumlah_bayar ?></td>
                    <td><?= $value->metode ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
@endsection
