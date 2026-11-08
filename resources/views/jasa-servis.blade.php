@extends('template')

@section('content')

    <h1 class="mb-3">Data Jasa Servis</h1>

    <a href="/tambah_jasa_servis" class="btn btn-secondary mb-3">Tambah Jasa Servis</a>

    <div class="card mt-3">
        <div class="card-body table-responsive">
            <h5 class="card-title">Data Jasa Servis</h5>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
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
                    <?php $no = 1; ?>
                    @foreach ($rows as $value)
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->kode_jasa ?></td>
                            <td><?= $value->nama_jasa ?></td>
                            <td><?= $value->harga ?></td>
                            <td><?= $value->estimasi_menit ?></td>
                            <td><?= $value->is_active ? 'Aktif' : 'Tidak Aktif' ?></td>
                            <td>
                                <a href="/edit_jasa_servis/<?= $value->id ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form action="/hapus_jasa_servis/<?= $value->id ?>" method="POST" class="d-inline">
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
