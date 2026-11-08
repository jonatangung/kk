@extends('template')

@section('content')

    <h1 class="mb-3">Laporan Pendapatan</h1>

    <form class="no-print d-flex flex-wrap align-items-center gap-3 mb-4" action="{{ url('/laporan-pendapatan') }}" method="GET">
        <label for="from" class="fw-semibold text-nowrap">Dari Tanggal:</label>
        <input type="date" id="from" name="from" value="{{ request('from') }}" class="form-control w-auto">

        <label for="to" class="fw-semibold text-nowrap">Sampai Tanggal:</label>
        <input type="date" id="to" name="to" value="{{ request('to') }}" class="form-control w-auto">

        <button type="submit" class="btn btn-secondary">Filter</button>
        <a href="/laporan-pendapatan" class="btn btn-secondary">Reset</a>
        <button type="button" class="btn btn-secondary" onclick="window.print()">Print</button>
        <a href="/laporan-pendapatan/pdf?from={{ request('from') }}&to={{ request('to') }}" class="btn btn-danger">PDF</a>
        <a href="/laporan-pendapatan/excel?from={{ request('from') }}&to={{ request('to') }}" class="btn btn-success">Excel</a>
    </form>

    <div class="card mt-3">
        <div class="card-body table-responsive">
            <h5 class="card-title">Laporan Pendapatan</h5>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>No Pembayaran</th>
                        <th>No Servis</th>
                        <th>Jasa Dipilih</th>
                        <th>Tanggal</th>
                        <th>Jumlah Bayar</th>
                        <th>Metode</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($rows as $value)
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->no_pembayaran ?></td>
                            <td><?= $value->no_servis ?? '-' ?></td>
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
                            <td class="fw-bold">Rp<?= number_format($value->total_jasa, 0, ',', '.') ?></td>
                            <td><?= ucfirst($value->metode) ?></td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="table-dark fw-bold">
                        <td colspan="5" class="text-end">Total Pendapatan</td>
                        <td class="text-end">Rp<?= number_format($totalPendapatan, 0, ',', '.') ?></td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

@endsection
