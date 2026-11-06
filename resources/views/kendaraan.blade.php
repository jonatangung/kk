@extends('template')
@section('content')
<h1>Data Kendaraan</h1>
<a href="/master/kendaraan/create" class="btn btn-secondary mb-3">Tambah Kendaraan</a>
<div class="card mt-3">
    <div class="card-header"><h5 class="card-title mb-0">Data Kendaraan</h5></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead><tr><th>No</th><th>No Polisi</th><th>Pelanggan ID</th><th>Merk</th><th>Model</th><th>Tahun</th><th>Warna</th><th>Aksi</th></tr></thead>
            <tbody>
            <?php
            $no = 1;
            foreach ($rows as $value) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $value->no_polisi ?></td>
                    <td><?= $value->pelanggan_id ?></td>
                    <td><?= $value->merk ?></td>
                    <td><?= $value->model ?></td>
                    <td><?= $value->tahun ?></td>
                    <td><?= $value->warna ?></td>
                    <td>
                        <a href="/master/kendaraan/<?= $value->id ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                        <form action="/master/kendaraan/<?= $value->id ?>" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data kendaraan?')">Delete</button>
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
