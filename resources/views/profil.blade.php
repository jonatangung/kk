@extends('template')

@section('content')

    <h1 class="mb-4">Pengaturan Profil</h1>

    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            @if ($user)
                <form method="POST" action="/profil" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3 text-center">
                        @if ($user->foto)
                            <img src="{{ asset('uploads/users/' . $user->foto) }}" alt="Foto" class="rounded-circle mb-2" style="width: 90px; height: 90px; object-fit: cover;">
                        @else
                            <img src="{{ asset('assets/img/profile-img.jpg') }}" alt="Foto" class="rounded-circle mb-2" style="width: 90px; height: 90px; object-fit: cover;">
                        @endif
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Foto Profil</label>
                        <input type="file" name="foto" class="form-control" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah foto.</small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Pengguna</label>
                        <input type="text" name="nama" class="form-control" value="{{ old('nama', $user->nama) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">No. HP</label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp', $user->no_hp) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Password Baru</label>
                        <input type="password" name="password" class="form-control" minlength="6" placeholder="Kosongkan jika tidak ingin mengganti password">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Profil</button>
                </form>
            @else
                <p class="text-muted mb-0">Data profil tidak ditemukan.</p>
            @endif
        </div>
    </div>

@endsection
