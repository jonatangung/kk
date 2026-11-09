@extends('template')

@section('content')

    <h1 class="mb-3">Data Jasa Servis</h1>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2 no-print">
        <a href="/tambah_jasa_servis" class="btn btn-secondary">Tambah Jasa Servis</a>
        <div>
            <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()">Print Window</button>
            <a href="/jasa-servis/pdf" target="_blank" class="btn btn-danger btn-sm">Download PDF</a>
            <a href="/jasa-servis/excel" class="btn btn-success btn-sm">Export Excel</a>
        </div>
    </div>

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
