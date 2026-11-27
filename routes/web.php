<?php

use Illuminate\Support\Facades\Route;

// =============================
// ROUTE TAMU (belum login)
// =============================
Route::middleware('guest')->group(function () {
    Route::get('/', 'App\Http\Controllers\LoginController@index');
    Route::get('/login', 'App\Http\Controllers\LoginController@index');
    Route::post('/login', 'App\Http\Controllers\LoginController@aksilogin');
    Route::get('/girasya', 'App\Http\Controllers\LoginController@register');
    Route::post('/input', 'App\Http\Controllers\LoginController@simpanRegister');
});

// =============================
// ROUTE SIGNED (QR Code Data Masuk)
// Tanpa login, hanya bisa diakses via signed URL yang berlaku 5 menit
// =============================
Route::middleware(['web', 'signed'])->group(function () {
    Route::get('/data-masuk', 'App\Http\Controllers\StokBarangController@dataMasukForm')->name('data-masuk.form');
});
Route::middleware(['web'])->group(function () {
    Route::post('/data-masuk/simpan', 'App\Http\Controllers\StokBarangController@simpanDataMasuk')->name('data-masuk.simpan');
});

// =============================
// ROUTE DASAR (login saja)
// =============================
Route::middleware('auth')->group(function () {
    Route::get('/home', 'App\Http\Controllers\LoginController@home');
    Route::get('/logout', 'App\Http\Controllers\LoginController@logout');
    Route::get('/profil', 'App\Http\Controllers\ProfilController@profil');
    Route::post('/profil', 'App\Http\Controllers\ProfilController@updateProfil');
});

// =============================
// HALAMAN LIHAT (read-only)
// Matriks mengacu ke App\Support\RolePermission
// =============================

// owner + admin + kasir: pelanggan, pembayaran, laporan pendapatan
Route::middleware(['auth', 'level:owner,admin,kasir'])->group(function () {
    Route::get('/pelanggan', 'App\Http\Controllers\PelangganController@pelanggan');
    Route::get('/pembayaran', 'App\Http\Controllers\PembayaranController@pembayaran');
    Route::get('/laporan-pendapatan', 'App\Http\Controllers\LaporanController@laporanPendapatan');
});

// owner + admin + kasir + mekanik: kendaraan, servis, laporan servis
Route::middleware(['auth', 'level:owner,admin,kasir,mekanik'])->group(function () {
    Route::get('/kendaraan', 'App\Http\Controllers\KendaraanController@kendaraan');
    Route::get('/servis', 'App\Http\Controllers\ServisController@servis');
    Route::get('/laporan-servis', 'App\Http\Controllers\LaporanController@laporanServis');
});

// owner + admin saja: mekanik, jasa servis, supplier, stok, pengguna
Route::middleware(['auth', 'level:owner,admin'])->group(function () {
    Route::get('/mekanik', 'App\Http\Controllers\MekanikController@karyawan');
    Route::get('/jasa-servis', 'App\Http\Controllers\JasaServisController@jasaServis');
    Route::get('/supplier', 'App\Http\Controllers\SupplierController@supplier');
    Route::get('/stok-barang', 'App\Http\Controllers\StokBarangController@stokBarang');
    Route::get('/pengguna', 'App\Http\Controllers\PenggunaController@pengguna');
});

// =============================
// TAMBAH / EDIT / HAPUS
// Owner TIDAK termasuk: owner hanya bisa melihat.
// =============================

// ROLE: admin + kasir (pelanggan & pembayaran)
Route::middleware(['auth', 'level:admin,kasir'])->group(function () {
    // Pelanggan
    Route::get('/tplg', 'App\Http\Controllers\PelangganController@tplg');
    Route::post('/aksi_tplg', 'App\Http\Controllers\PelangganController@aksi_tplg');
    Route::get('/edit_pelanggan/{id}', 'App\Http\Controllers\PelangganController@editPelanggan');
    Route::post('/edit_pelanggan_aksi/{id}', 'App\Http\Controllers\PelangganController@updatePelanggan');
    Route::post('/hapus_pelanggan/{id}', 'App\Http\Controllers\PelangganController@hapusPelanggan');

    // Pembayaran
    Route::get('/edit_pembayaran/{id}', 'App\Http\Controllers\PembayaranController@editPembayaran');
    Route::post('/edit_pembayaran_aksi/{id}', 'App\Http\Controllers\PembayaranController@updatePembayaran');
    Route::post('/hapus_pembayaran/{id}', 'App\Http\Controllers\PembayaranController@hapusPembayaran');
});

// ROLE: admin saja (kendaraan - read-only untuk role lain)
Route::middleware(['auth', 'level:admin'])->group(function () {
    // Kendaraan
    Route::get('/tambah_kendaraan', 'App\Http\Controllers\KendaraanController@tambahKendaraan');
    Route::post('/tambah_kendaraan_aksi', 'App\Http\Controllers\KendaraanController@simpanKendaraan');
    Route::get('/edit_kendaraan/{id}', 'App\Http\Controllers\KendaraanController@editKendaraan');
    Route::post('/edit_kendaraan_aksi/{id}', 'App\Http\Controllers\KendaraanController@updateKendaraan');
    Route::post('/hapus_kendaraan/{id}', 'App\Http\Controllers\KendaraanController@hapusKendaraan');
});

// ROLE: admin + kasir (input transaksi servis; mekanik hanya melihat)
Route::middleware(['auth', 'level:admin,kasir'])->group(function () {
    // Servis
    Route::get('/tambah_servis', 'App\Http\Controllers\ServisController@tambahServis');
    Route::post('/tambah_servis_aksi', 'App\Http\Controllers\ServisController@simpanServis');
    Route::get('/edit_servis/{id}', 'App\Http\Controllers\ServisController@editServis');
    Route::post('/edit_servis_aksi/{id}', 'App\Http\Controllers\ServisController@updateServis');
    Route::post('/hapus_servis/{id}', 'App\Http\Controllers\ServisController@hapusServis');
});

// ROLE: admin saja (mekanik, jasa servis, supplier, stok barang, pengguna)
Route::middleware(['auth', 'level:admin'])->group(function () {
    // Mekanik
    Route::get('/tkry', 'App\Http\Controllers\MekanikController@tkry');
    Route::post('/aksi_tkry', 'App\Http\Controllers\MekanikController@aksi_tkry');
    Route::get('/edit_mekanik/{id}', 'App\Http\Controllers\MekanikController@editMekanik');
    Route::post('/edit_mekanik_aksi/{id}', 'App\Http\Controllers\MekanikController@updateMekanik');
    Route::post('/hapus_mekanik/{id}', 'App\Http\Controllers\MekanikController@hapusMekanik');

    // Jasa Servis
    Route::get('/tambah_jasa_servis', 'App\Http\Controllers\JasaServisController@tambahJasaServis');
    Route::post('/tambah_jasa_servis_aksi', 'App\Http\Controllers\JasaServisController@simpanJasaServis');
    Route::get('/edit_jasa_servis/{id}', 'App\Http\Controllers\JasaServisController@editJasaServis');
    Route::post('/edit_jasa_servis_aksi/{id}', 'App\Http\Controllers\JasaServisController@updateJasaServis');
    Route::post('/hapus_jasa_servis/{id}', 'App\Http\Controllers\JasaServisController@hapusJasaServis');

    // Supplier
    Route::get('/tambah_supplier', 'App\Http\Controllers\SupplierController@tambahSupplier');
    Route::post('/tambah_supplier_aksi', 'App\Http\Controllers\SupplierController@simpanSupplier');
    Route::get('/edit_supplier/{id}', 'App\Http\Controllers\SupplierController@editSupplier');
    Route::post('/edit_supplier_aksi/{id}', 'App\Http\Controllers\SupplierController@updateSupplier');
    Route::post('/hapus_supplier/{id}', 'App\Http\Controllers\SupplierController@hapusSupplier');

    // Stok Barang
    Route::get('/input_stok_barang', 'App\Http\Controllers\StokBarangController@inputStokBarang');
    Route::post('/stok-barang_tambah', 'App\Http\Controllers\StokBarangController@stokMasuk');
    Route::post('/stok-barang_keluar/{id}', 'App\Http\Controllers\StokBarangController@stokKeluar');
    Route::get('/stok-barang/generate-qr', 'App\Http\Controllers\StokBarangController@generateQRCode')->name('stok-barang.generate-qr');

    // Pengguna
    Route::get('/tambah_users', 'App\Http\Controllers\PenggunaController@tambahPengguna');
    Route::post('/tambah_users_aksi', 'App\Http\Controllers\PenggunaController@simpanPengguna');
    Route::get('/edit_users/{id}', 'App\Http\Controllers\PenggunaController@editPengguna');
    Route::post('/edit_users_aksi/{id}', 'App\Http\Controllers\PenggunaController@updatePengguna');
    Route::post('/hapus_users/{id}', 'App\Http\Controllers\PenggunaController@hapusPengguna');

    // Setting (khusus admin — identitas usaha)
    Route::get('/setting', 'App\Http\Controllers\SettingController@index');
    Route::post('/setting/aksi', 'App\Http\Controllers\SettingController@update');
});

// =============================
// EXPORT PDF & EXCEL
// Semua role yang login boleh mencoba, tapi controller menegakkan
// RolePermission::cek('export:<fitur>') sehingga hanya admin & kasir
// yang benar-benar bisa mengunduh. Role lain mendapat 403 Forbidden.
// =============================
Route::middleware('auth')->group(function () {
    Route::get('/pelanggan/pdf', 'App\Http\Controllers\PelangganController@pdfPelanggan');
    Route::get('/pelanggan/excel', 'App\Http\Controllers\PelangganController@excelPelanggan');
    Route::get('/pembayaran/pdf', 'App\Http\Controllers\PembayaranController@pdfPembayaran');
    Route::get('/pembayaran/excel', 'App\Http\Controllers\PembayaranController@excelPembayaran');
    Route::get('/kendaraan/pdf', 'App\Http\Controllers\KendaraanController@pdfKendaraan');
    Route::get('/kendaraan/excel', 'App\Http\Controllers\KendaraanController@excelKendaraan');
    Route::get('/servis/pdf', 'App\Http\Controllers\ServisController@pdfServis');
    Route::get('/servis/excel', 'App\Http\Controllers\ServisController@excelServis');
    Route::get('/jasa-servis/pdf', 'App\Http\Controllers\JasaServisController@pdfJasaServis');
    Route::get('/jasa-servis/excel', 'App\Http\Controllers\JasaServisController@excelJasaServis');
    Route::get('/mekanik/pdf', 'App\Http\Controllers\MekanikController@pdfMekanik');
    Route::get('/mekanik/excel', 'App\Http\Controllers\MekanikController@excelMekanik');
    Route::get('/supplier/pdf', 'App\Http\Controllers\SupplierController@pdfSupplier');
    Route::get('/supplier/excel', 'App\Http\Controllers\SupplierController@excelSupplier');
    Route::get('/stok-barang/pdf', 'App\Http\Controllers\StokBarangController@pdfStokBarang');
    Route::get('/stok-barang/excel', 'App\Http\Controllers\StokBarangController@excelStokBarang');
    Route::get('/pengguna/pdf', 'App\Http\Controllers\PenggunaController@pdfPengguna');
    Route::get('/pengguna/excel', 'App\Http\Controllers\PenggunaController@excelPengguna');
});
