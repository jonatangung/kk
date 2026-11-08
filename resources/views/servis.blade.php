@extends('template')

@section('content')

    <h1 class="mb-3">Transaksi Servis</h1>

    <a href="/tambah_servis" class="btn btn-secondary mb-3">Tambah Servis</a>

    <div class="card mt-3">
        <div class="card-body table-responsive">
            <h5 class="card-title">Transaksi Servis</h5>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Jasa Servis</th>
                        <th>Harga</th>
                        <th>Mekanik</th>
                        <th>Metode Pembayaran</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($rows as $value)
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->nama_pelanggan ?></td>
                            <td><?= $value->no_polisi ?></td>
                            <td><?= $value->daftar_jasa ?></td>
                            <td>Rp<?= number_format($value->total_jasa, 0, ',', '.') ?></td>
                            <td><?= $value->nama_mekanik ?: '-' ?></td>
                            <td><?= $value->metode_pembayaran ?: '-' ?></td>
                            <td><?= $value->tanggal_masuk ?></td>
                            <td><?= ucfirst($value->status) ?></td>
                            <td>
                                <a href="/edit_servis/{{ $value->id }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="/hapus_servis/{{ $value->id }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
