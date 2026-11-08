@extends('template')

@section('content')

    <h1 class="mb-3">Laporan Servis</h1>

    <form class="no-print d-flex flex-wrap align-items-center gap-3 mb-4" action="{{ url('/laporan-servis') }}" method="GET">
        <label for="from" class="fw-semibold text-nowrap">Dari Tanggal:</label>
        <input type="date" id="from" name="from" value="{{ request('from') }}" class="form-control w-auto">

        <label for="to" class="fw-semibold text-nowrap">Sampai Tanggal:</label>
        <input type="date" id="to" name="to" value="{{ request('to') }}" class="form-control w-auto">

        <button type="submit" class="btn btn-secondary">Filter</button>
        <a href="/laporan-servis" class="btn btn-secondary">Reset</a>
        <button type="button" class="btn btn-secondary" onclick="window.print()">Print</button>
        <a href="/laporan-servis?from={{ request('from') }}&to={{ request('to') }}&export=pdf" class="btn btn-danger">PDF</a>
        <a href="/laporan-servis?from={{ request('from') }}&to={{ request('to') }}&export=excel" class="btn btn-success">Excel</a>
    </form>

    <div class="card mt-3">
        <div class="card-body table-responsive">
            <h5 class="card-title">Laporan Servis</h5>

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>No Servis</th>
                        <th>Pelanggan</th>
                        <th>No Polisi</th>
                        <th>Mekanik</th>
                        <th>Tanggal Masuk</th>
                        <th>Keluhan</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($rows as $value)
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $value->no_servis ?></td>
                            <td><?= $value->nama_pelanggan ?></td>
                            <td><?= $value->no_polisi ?></td>
                            <td><?= $value->nama_mekanik ?: '-' ?></td>
                            <td><?= $value->tanggal_masuk ?></td>
                            <td><?= $value->keluhan ?: '-' ?></td>
                            <td><?= ucfirst($value->status) ?></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
