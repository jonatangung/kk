@extends('template')
@section('content')
<h1>Data Supplier</h1>
<a href="/master/supplier/create" class="btn btn-secondary mb-3">Tambah Supplier</a>
<div class="card mt-3">
    <div class="card-header"><h5 class="card-title mb-0">Data Supplier</h5></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead><tr><th>No</th><th>Nama Supplier</th><th>Kontak</th><th>No HP</th><th>Email</th><th>Alamat</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php
            $no = 1;
            foreach ($rows as $value) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $value->nama_supplier ?></td>
                    <td><?= $value->kontak_person ?></td>
                    <td><?= $value->no_hp ?></td>
                    <td><?= $value->email ?></td>
                    <td><?= $value->alamat ?></td>
                    <td>
                        <a href="/master/supplier/<?= $value->id ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                        <form action="/master/supplier/<?= $value->id ?>" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data supplier?')">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
@endsection
