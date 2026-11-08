@extends('template')

@section('content')

    <h1 class="mb-3">Data Kendaraan</h1>

    <a href="/tambah_kendaraan" class="btn btn-secondary mb-3">Tambah Kendaraan</a>

    <div class="card mt-3">
        <div class="card-body table-responsive">
            <h5 class="card-title">Data Kendaraan</h5>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>No Polisi</th>
                        <th>Pelanggan ID</th>
                        <th>Merk</th>
                        <th>Model</th>
                        <th>Tahun</th>
                        <th>Warna</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($rows as $value)
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->no_polisi ?></td>
                            <td><?= $value->pelanggan_id ?></td>
                            <td><?= $value->merk ?></td>
                            <td><?= $value->model ?></td>
                            <td><?= $value->tahun ?></td>
                            <td><?= $value->warna ?></td>
                            <td>
                                <a href="/edit_kendaraan/<?= $value->id ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form action="/hapus_kendaraan/<?= $value->id ?>" method="POST" class="d-inline">
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
