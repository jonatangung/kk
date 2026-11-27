@extends('template')

@section('back_url', '/home')
@section('back_text', 'Kembali ke Dashboard')

@section('content')
{{-- Halaman pengaturan identitas usaha. Data dikirim ke SettingController method update() --}}

    <div class="card shadow-sm border-0 border-top border-warning border-3">
        <div class="card-header bg-white py-3">
            <h5 class="card-title mb-0">Pengaturan Usaha</h5>
        </div>

        <div class="card-body">
            <?php if (session('sukses')) { ?>
                <div class="alert alert-success"><?php echo session('sukses'); ?></div>
            <?php } ?>

            <form action="/setting/aksi" method="POST" enctype="multipart/form-data" class="row g-3 no-print">
                @csrf

                <div class="col-12">
                    <label class="form-label">Nama Usaha</label>
                    <input type="text" name="nama_usaha" class="form-control" value="<?php echo old('nama_usaha', $setting->nama_usaha); ?>" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Nama Owner</label>
                    <input type="text" name="nama_owner" class="form-control" value="<?php echo old('nama_owner', $setting->nama_owner); ?>" required>
                </div>

                <div class="col-12">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2"><?php echo old('alamat', $setting->alamat); ?></textarea>
                </div>

                <div class="col-12">
                    <label class="form-label">Logo Usaha</label>
                    <input type="file" name="logo" class="form-control" accept=".jpg,.jpeg,.png,.ico,.svg,.webp">
                    <div class="form-text">Format: jpg, jpeg, png, ico, svg, webp. Maksimal 2 MB. Kosongkan jika tidak ingin mengganti.</div>
                    <div class="mt-2">
                        <span class="text-muted small">Preview logo saat ini:</span><br>
                        <img src="<?php echo $dataSetting['logo_url']; ?>" alt="Logo" height="60" class="border rounded p-1 mt-1">
                    </div>
                </div>

                <div class="col-12">
                    <label class="form-label">Ikon (Favicon)</label>
                    <input type="file" name="ikon" class="form-control" accept=".jpg,.jpeg,.png,.ico,.svg,.webp">
                    <div class="form-text">Format: jpg, jpeg, png, ico, svg, webp. Maksimal 2 MB. Kosongkan jika tidak ingin mengganti.</div>
                    <div class="mt-2">
                        <span class="text-muted small">Preview ikon saat ini:</span><br>
                        <img src="<?php echo $dataSetting['ikon_url']; ?>" alt="Ikon" height="32" class="border rounded p-1 mt-1">
                    </div>
                </div>

                <div class="col-12 d-flex gap-2 mt-2">
                    <button type="submit" class="btn btn-warning text-dark fw-semibold rounded-pill"><i class="bi bi-check-lg-circle"></i> Simpan</button>
                    <a href="/home" class="btn btn-outline-secondary rounded-pill"><i class="bi bi-arrow-left"></i> Kembali</a>
                </div>
            </form>
        </div>
    </div>

@endsection
