@extends('template')

@section('content')

    <h1 class="mb-4">Pengaturan Profil</h1>

    <div class="card">
        <div class="card-body">
            @if ($user)
                <form method="POST" action="/profil">
                    @csrf

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
