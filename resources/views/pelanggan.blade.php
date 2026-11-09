@extends('template')

@section('content')

    <h1 class="mb-3">Data Pelanggan</h1>

    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2 no-print">
        <a href="/tplg" class="btn btn-secondary">Tambah Pelanggan</a>
        <div>
            <button type="button" class="btn btn-secondary btn-sm" onclick="window.print()">Print Window</button>
            <a href="{{ '/pelanggan/pdf' . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}" target="_blank" class="btn btn-danger btn-sm">Download PDF</a>
            <a href="{{ '/pelanggan/excel' . (request()->getQueryString() ? '?' . request()->getQueryString() : '') }}" class="btn btn-success btn-sm">Export Excel</a>
        </div>
    </div>

    

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
