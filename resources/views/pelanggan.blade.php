@extends('template')

@section('content')

    <h1 class="mb-3">Data Pelanggan</h1>

    <a href="/tplg" class="btn btn-secondary mb-3">Tambah Pelanggan</a>

    <form class="no-print d-flex flex-wrap align-items-center gap-3 mb-4" action="{{ url('/pelanggan') }}" method="GET">
        <label for="from" class="fw-semibold text-nowrap">Dari Tanggal:</label>
        <input type="date" id="from" name="from" value="{{ request('from') }}" class="form-control w-auto">

        <label for="to" class="fw-semibold text-nowrap">Sampai Tanggal:</label>
        <input type="date" id="to" name="to" value="{{ request('to') }}" class="form-control w-auto">

        <button type="submit" class="btn btn-secondary">Filter</button>
        <a href="/pelanggan" class="btn btn-secondary me-3">Reset</a>
    </form>

    <div class="card mt-3">
        <div class="card-body table-responsive">
            <h5 class="card-title">Daftar Pelanggan</h5>

            <table id="users-table" class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama Pelanggan</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($pelanggan as $value)
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>{{ $value->nama }}</td>
                            <td>{{ $value->alamat }}</td>
                            <td>{{ $value->email }}</td>
                            <td>{{ $value->no_hp }}</td>
                            <td>
                                <a href="/edit_pelanggan/{{ $value->id }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="/hapus_pelanggan/{{ $value->id }}" method="POST" class="d-inline">
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
