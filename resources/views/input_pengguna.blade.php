@extends('template')

@section('content')

    <h1 class="mb-4 fw-bold">Tambah Pengguna</h1>

    <div class="card">
        <div class="card-body">
            <form action="/tambah_users_aksi" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="fw-semibold">Nama</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">-- Pilih Role --</option>
                        @foreach (['admin' => 'Admin', 'kasir' => 'Kasir', 'mekanik' => 'Mekanik', 'owner' => 'Owner'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('role') == $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">No HP</label>
                    <input type="text" name="no_hp" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="fw-semibold">Foto Profil</label>
                    <input type="file" name="foto" class="form-control" accept="image/*" required>
                </div>

                <button class="btn btn-primary" type="submit">Simpan</button>
                <a href="/pengguna" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>

@endsection
