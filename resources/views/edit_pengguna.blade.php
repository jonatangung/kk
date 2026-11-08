@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Edit Pengguna</h1>

    <div class="card">
        <div class="card-body">
            <form action="/edit_users_aksi/{{ $row->id }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Nama</label>
                    <input type="text" name="nama" value="{{ $row->nama }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Email</label>
                    <input type="email" name="email" value="{{ $row->email }}" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Role</label>
                    <select name="role" class="form-control" required>
                        @foreach (['admin' => 'Admin', 'kasir' => 'Kasir', 'mekanik' => 'Mekanik', 'owner' => 'Owner'] as $value => $label)
                            <option value="{{ $value }}" @selected($row->role == $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">No HP</label>
                    <input type="text" name="no_hp" value="{{ $row->no_hp }}" class="form-control">
                </div>

                <button class="btn btn-warning" type="submit">Perbarui</button>
                <a href="/pengguna" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
