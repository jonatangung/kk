<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\logincontroller@index');
Route::get('/login', 'App\Http\Controllers\logincontroller@index');
Route::post('/login', 'App\Http\Controllers\logincontroller@aksilogin');

Route::get('/home', 'App\Http\Controllers\logincontroller@home');
Route::get('/logout', 'App\Http\Controllers\logincontroller@logout');

Route::get('/girasya', 'App\Http\Controllers\logincontroller@tampil');
Route::post('/input', 'App\Http\Controllers\logincontroller@zano');

Route::get('/edit/{user}', 'App\Http\Controllers\logincontroller@editview');
Route::put('/edit/{user}', 'App\Http\Controllers\logincontroller@update');
Route::delete('/delete/{user}', 'App\Http\Controllers\logincontroller@delete');

Route::get('/tkry', 'App\Http\Controllers\logincontroller@tkry');
Route::post('/aksi_tkry', 'App\Http\Controllers\logincontroller@aksi_tkry');
Route::get('/karyawan', 'App\Http\Controllers\logincontroller@karyawan');
Route::get('/mekanik', 'App\Http\Controllers\logincontroller@karyawan');

Route::get('/pelanggan', 'App\Http\Controllers\logincontroller@pelanggan');
Route::get('/tplg', 'App\Http\Controllers\logincontroller@tplg');
Route::post('/aksi_tplg', 'App\Http\Controllers\logincontroller@aksi_tplg');
Route::get('/master/{table}/create', 'App\Http\Controllers\logincontroller@createMaster');
Route::post('/master/{table}', 'App\Http\Controllers\logincontroller@storeMaster');
Route::get('/master/{table}/{id}/edit', 'App\Http\Controllers\logincontroller@editMaster');
Route::put('/master/{table}/{id}', 'App\Http\Controllers\logincontroller@updateMaster');
Route::delete('/master/{table}/{id}', 'App\Http\Controllers\logincontroller@deleteMaster');

Route::get('/kendaraan', 'App\Http\Controllers\logincontroller@kendaraan');
Route::get('/jasa-servis', 'App\Http\Controllers\logincontroller@jasaServis');
Route::get('/sparepart', 'App\Http\Controllers\logincontroller@sparepart');
Route::get('/supplier', 'App\Http\Controllers\logincontroller@supplier');
Route::get('/servis', 'App\Http\Controllers\logincontroller@servis');
Route::get('/pembelian', 'App\Http\Controllers\logincontroller@pembelian');
Route::get('/pembayaran', 'App\Http\Controllers\logincontroller@pembayaran');
Route::get('/stok-masuk', 'App\Http\Controllers\logincontroller@stokMasuk');
Route::get('/stok-riwayat', 'App\Http\Controllers\logincontroller@stokKeluar');
Route::get('/stok-opname', 'App\Http\Controllers\logincontroller@stokOpname');
Route::get('/laporan-servis', 'App\Http\Controllers\logincontroller@laporanServis');
Route::get('/laporan-pendapatan', 'App\Http\Controllers\logincontroller@laporanPendapatan');
Route::get('/laporan-persediaan', 'App\Http\Controllers\logincontroller@laporanPersediaan');
Route::get('/pengguna', 'App\Http\Controllers\logincontroller@pengguna');
Route::get('/profil', 'App\Http\Controllers\logincontroller@profil');
Route::post('/profil', 'App\Http\Controllers\logincontroller@updateProfil');
