@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Edit Pengguna</h1>

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="/edit_users_aksi/{{ $row->id }}" method="POST" enctype="multipart/form-data">
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
                        @foreach (['owner' => 'Owner', 'admin' => 'Admin', 'kasir' => 'Kasir', 'karyawan' => 'Karyawan', 'mekanik' => 'Mekanik'] as $value => $label)
                            <option value="{{ $value }}" @selected($row->role == $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">No HP</label>
                    <input type="text" name="no_hp" value="{{ $row->no_hp }}" class="form-control">
                </div>


                <div class="mb-3">
                    <label class="fw-semibold">Foto Profil</label>
                    @if ($row->foto)
                        <div class="mb-2">
                            <img src="{{ asset('uploads/users/' . $row->foto) }}" alt="Foto" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px;">
                        </div>
                    @endif
                    <input type="file" name="foto" class="form-control" accept="image/*">
                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                </div>

                <button class="btn btn-warning" type="submit">Perbarui</button>
                <a href="/pengguna" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
