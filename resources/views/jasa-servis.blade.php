@extends('template')
@section('content')
<h1>Data Jasa Servis</h1>
<a href="/master/jasa_servis/create" class="btn btn-secondary mb-3">Tambah Jasa Servis</a>
<div class="card mt-3">
    <div class="card-header"><h5 class="card-title mb-0">Data Jasa Servis</h5></div>
    <div class="card-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Jasa</th>
                    <th>Nama Jasa</th>
                    <th>Harga</th>
                    <th>Estimasi Menit</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $no = 1;
            foreach ($rows as $value) {
            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $value->kode_jasa ?></td>
                    <td><?= $value->nama_jasa ?></td>
                    <td><?= $value->harga ?></td>
                    <td><?= $value->estimasi_menit ?></td>
                    <td><?= $value->is_active ? 'Aktif' : 'Tidak Aktif' ?></td>
                    <td>
                        <a href="/master/jasa_servis/<?= $value->id ?>/edit" class="btn btn-sm btn-warning">Edit</a>
                        <form action="/master/jasa_servis/<?= $value->id ?>" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data jasa servis?')">Delete</button>
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
