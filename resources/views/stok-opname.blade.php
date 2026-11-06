@extends('template')
@section('content')
<h1>Stok Opname</h1>
<a href="/master/stok_opname/create" class="btn btn-secondary mb-3">Tambah Stok Opname</a>
<div class="card mt-3">
    <div class="card-header"><h5 class="card-title mb-0">Stok Opname</h5></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead><tr><th>No</th><th>Sparepart ID</th><th>Tanggal</th><th>Stok Sistem</th><th>Stok Fisik</th><th>Selisih</th></tr></thead>
            <tbody>
            <?php
            $no = 1;
            foreach ($rows as $value) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $value->sparepart_id ?></td>
                    <td><?= $value->tanggal ?></td>
                    <td><?= $value->stok_sistem ?></td>
                    <td><?= $value->stok_fisik ?></td>
                    <td><?= $value->selisih ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
@endsection
