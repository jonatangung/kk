<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\logincontroller@index');
Route::get('/login', 'App\Http\Controllers\logincontroller@index');
Route::post('/login', 'App\Http\Controllers\logincontroller@aksilogin');
Route::get('/girasya', 'App\Http\Controllers\logincontroller@register');
Route::post('/input', 'App\Http\Controllers\logincontroller@simpanRegister');

Route::get('/home', 'App\Http\Controllers\logincontroller@home');
Route::get('/logout', 'App\Http\Controllers\logincontroller@logout');

//Mekanik
Route::get('/tkry', 'App\Http\Controllers\logincontroller@tkry');
Route::post('/aksi_tkry', 'App\Http\Controllers\logincontroller@aksi_tkry');
Route::get('/mekanik', 'App\Http\Controllers\logincontroller@karyawan');
Route::get('/edit_mekanik/{id}', 'App\Http\Controllers\logincontroller@editMekanik');
Route::post('/edit_mekanik_aksi/{id}', 'App\Http\Controllers\logincontroller@updateMekanik');
Route::post('/hapus_mekanik/{id}', 'App\Http\Controllers\logincontroller@hapusMekanik');

// Pelanggan
Route::get('/pelanggan', 'App\Http\Controllers\logincontroller@pelanggan');
Route::get('/tplg', 'App\Http\Controllers\logincontroller@tplg');
Route::post('/aksi_tplg', 'App\Http\Controllers\logincontroller@aksi_tplg');
Route::get('/edit_pelanggan/{id}', 'App\Http\Controllers\logincontroller@editPelanggan');
Route::post('/edit_pelanggan_aksi/{id}', 'App\Http\Controllers\logincontroller@updatePelanggan');
Route::post('/hapus_pelanggan/{id}', 'App\Http\Controllers\logincontroller@hapusPelanggan');

// Kendaraan
Route::get('/kendaraan', 'App\Http\Controllers\logincontroller@kendaraan');
Route::get('/tambah_kendaraan', 'App\Http\Controllers\logincontroller@tambahKendaraan');
Route::post('/tambah_kendaraan_aksi', 'App\Http\Controllers\logincontroller@simpanKendaraan');
Route::get('/edit_kendaraan/{id}', 'App\Http\Controllers\logincontroller@editKendaraan');
Route::post('/edit_kendaraan_aksi/{id}', 'App\Http\Controllers\logincontroller@updateKendaraan');
Route::post('/hapus_kendaraan/{id}', 'App\Http\Controllers\logincontroller@hapusKendaraan');

// Jasa Servis
Route::get('/jasa-servis', 'App\Http\Controllers\logincontroller@jasaServis');
Route::get('/tambah_jasa_servis', 'App\Http\Controllers\logincontroller@tambahJasaServis');
Route::post('/tambah_jasa_servis_aksi', 'App\Http\Controllers\logincontroller@simpanJasaServis');
Route::get('/edit_jasa_servis/{id}', 'App\Http\Controllers\logincontroller@editJasaServis');
Route::post('/edit_jasa_servis_aksi/{id}', 'App\Http\Controllers\logincontroller@updateJasaServis');
Route::post('/hapus_jasa_servis/{id}', 'App\Http\Controllers\logincontroller@hapusJasaServis');

// Supplier
Route::get('/supplier', 'App\Http\Controllers\logincontroller@supplier');
Route::get('/tambah_supplier', 'App\Http\Controllers\logincontroller@tambahSupplier');
Route::post('/tambah_supplier_aksi', 'App\Http\Controllers\logincontroller@simpanSupplier');
Route::get('/edit_supplier/{id}', 'App\Http\Controllers\logincontroller@editSupplier');
Route::post('/edit_supplier_aksi/{id}', 'App\Http\Controllers\logincontroller@updateSupplier');
Route::post('/hapus_supplier/{id}', 'App\Http\Controllers\logincontroller@hapusSupplier');

// Servis
Route::get('/servis', 'App\Http\Controllers\logincontroller@servis');
Route::get('/tambah_servis', 'App\Http\Controllers\logincontroller@tambahServis');
Route::post('/tambah_servis_aksi', 'App\Http\Controllers\logincontroller@simpanServis');
Route::get('/edit_servis/{id}', 'App\Http\Controllers\logincontroller@editServis');
Route::post('/edit_servis_aksi/{id}', 'App\Http\Controllers\logincontroller@updateServis');
Route::post('/hapus_servis/{id}', 'App\Http\Controllers\logincontroller@hapusServis');

// Pembayaran
Route::get('/pembayaran', 'App\Http\Controllers\logincontroller@pembayaran');
Route::get('/edit_pembayaran/{id}', 'App\Http\Controllers\logincontroller@editPembayaran');
Route::post('/edit_pembayaran_aksi/{id}', 'App\Http\Controllers\logincontroller@updatePembayaran');
Route::post('/hapus_pembayaran/{id}', 'App\Http\Controllers\logincontroller@hapusPembayaran');

// Laporan
Route::get('/laporan-servis', 'App\Http\Controllers\logincontroller@laporanServis');
Route::get('/laporan-pendapatan', 'App\Http\Controllers\logincontroller@laporanPendapatan');
Route::get('/stok-barang', 'App\Http\Controllers\logincontroller@stokBarang');
Route::get('/input_stok_barang', 'App\Http\Controllers\logincontroller@inputStokBarang');
Route::post('/stok-barang_keluar/{id}', 'App\Http\Controllers\logincontroller@stokKeluar');
Route::post('/stok-barang_tambah', 'App\Http\Controllers\logincontroller@stokMasuk');

// Pengguna
Route::get('/pengguna', 'App\Http\Controllers\logincontroller@pengguna');
Route::get('/tambah_users', 'App\Http\Controllers\logincontroller@tambahPengguna');
Route::post('/tambah_users_aksi', 'App\Http\Controllers\logincontroller@simpanPengguna');
Route::get('/edit_users/{id}', 'App\Http\Controllers\logincontroller@editPengguna');
Route::post('/edit_users_aksi/{id}', 'App\Http\Controllers\logincontroller@updatePengguna');
Route::post('/hapus_users/{id}', 'App\Http\Controllers\logincontroller@hapusPengguna');

// Profil
Route::get('/profil', 'App\Http\Controllers\logincontroller@profil');
Route::post('/profil', 'App\Http\Controllers\logincontroller@updateProfil');
