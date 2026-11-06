@extends('template')
@section('content')
<h1>Manajemen Pengguna</h1>
<a href="/master/users/create" class="btn btn-secondary mb-3">Tambah Pengguna</a>
<div class="card mt-3">
    <div class="card-header"><h5 class="card-title mb-0">Manajemen Pengguna</h5></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead><tr><th>No</th><th>Nama</th><th>Email</th><th>Role</th><th>No HP</th><th>Status</th></tr></thead>
            <tbody>
            <?php
            $no = 1;
            foreach ($rows as $value) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $value->nama ?></td>
                    <td><?= $value->email ?></td>
                    <td><?= $value->role ?></td>
                    <td><?= $value->no_hp ?></td>
                    <td><?= $value->is_active ? 'Aktif' : 'Tidak Aktif' ?></td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
@endsection
