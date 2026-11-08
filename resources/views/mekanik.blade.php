@extends('template')

@section('content')

    <h1 class="mb-3">Data Mekanik</h1>

    <a href="/tkry" class="btn btn-secondary mb-3">Tambah Mekanik</a>

    <div class="card">
        <div class="card-body table-responsive">
            <h5 class="card-title">Daftar Mekanik</h5>

            <table class="table table-bordered table-striped align-middle mt-3">
                <thead class="table-dark text-center">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>No HP</th>
                        <th>Spesialisasi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; ?>
                    @foreach ($karyawan as $value)
                        @if ($value->nama)
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>{{ $value->nama }}</td>
                                <td>{{ $value->no_hp ?: '-' }}</td>
                                <td>{{ $value->spesialisasi ?: '-' }}</td>
                                <td>{{ ucfirst($value->status) }}</td>
                                <td>
                                    <a href="/edit_mekanik/{{ $value->id }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="/hapus_mekanik/{{ $value->id }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
