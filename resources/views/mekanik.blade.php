@extends('template')
@section('content')

<h1>Data Mekanik</h1>
<a href="/tkry" class="btn btn-secondary mb-3">Tambah Mekanik</a>

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">Daftar Mekanik</h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped mt-3">
            <thead>
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
                            <a href="/master/mekanik/{{ $value->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                            <form action="/master/mekanik/{{ $value->id }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data mekanik?')">Delete</button>
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
