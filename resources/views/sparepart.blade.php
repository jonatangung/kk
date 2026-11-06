@extends('template')
@section('content')
<h1>Data Sparepart</h1>
<a href="/master/sparepart/create" class="btn btn-secondary mb-3">Tambah Sparepart</a>
<div class="card mt-3">
    <div class="card-header"><h5 class="card-title mb-0">Stok Sparepart</h5></div>
        <table class="table table-bordered table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Sparepart</th>
                    <th>Kategori</th>
                    <th>Merk</th>
                    <th>Stok</th>
                    <th>Minimum</th>
                    <th>Lokasi Rak</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($rows as $row)
                    <tr class="{{ $row->stok <= $row->stok_minimum ? 'table-warning' : '' }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->nama_sparepart }}</td>
                        <td>{{ $row->kategori ?: '-' }}</td>
                        <td>{{ $row->merk ?: '-' }}</td>
                        <td>{{ $row->stok }} {{ $row->satuan }}</td>
                        <td>{{ $row->stok_minimum }}</td>
                        <td>{{ $row->lokasi_rak ?: '-' }}</td>
                        <td>
                            <a href="/master/sparepart/{{ $row->id }}/edit" class="btn btn-sm btn-warning">Edit</a>
                            <form action="/master/sparepart/{{ $row->id }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data sparepart?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted">Belum ada data sparepart.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
