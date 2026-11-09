@extends('template')

@section('content')

    <h1 class="mb-3">Pembayaran</h1>

    <div class="d-flex flex-wrap justify-content-end align-items-center mb-3 gap-2 no-print">
        <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()">Print Window</button>
        <a href="/pembayaran/pdf" target="_blank" class="btn btn-danger btn-sm">Download PDF</a>
        <a href="/pembayaran/excel" class="btn btn-success btn-sm">Export Excel</a>
    </div>

    <div class="card mt-3">
        <div class="card-body table-responsive">
            <h5 class="card-title">Pembayaran</h5>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>No Pembayaran</th>
                        <th>No Servis</th>
                        <th>Keluhan</th>
                        <th>Jasa Dipilih</th>
                        <th>Tanggal</th>
                        <th>Jumlah Bayar</th>
                        <th>Metode</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($rows as $value)
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->no_pembayaran ?></td>
                            <td><?= $value->no_servis ?? '-' ?></td>
                            <td><?= $value->keluhan ?? '-' ?></td>
                            <td>
                                @php $jasaList = $jasaByServis->get($value->servis_id, collect()); @endphp
                                @forelse ($jasaList as $jasa)
                                    <div>
                                        {{ $jasa->nama_jasa }} ({{ $jasa->jumlah }}x) —
                                        Rp<?= number_format($jasa->jumlah * $jasa->harga, 0, ',', '.') ?>
                                    </div>
                                @empty
                                    <span class="text-muted">-</span>
                                @endforelse
                            </td>
                            <td><?= $value->tanggal ?></td>
                            <td class="fw-bold">Rp<?= number_format($value->jumlah_bayar, 0, ',', '.') ?></td>
                            <td><?= ucfirst($value->metode) ?></td>
                            <td>
                                <a href="/edit_pembayaran/<?= $value->id ?>" class="btn btn-sm btn-warning">Edit</a>
                                <form action="/hapus_pembayaran/<?= $value->id ?>" method="POST" class="d-inline">
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
