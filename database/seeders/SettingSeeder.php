<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

//----- SettingSeeder: mengisi 1 baris data setting dengan nilai default
//----- Logo & ikon default disalin dari assets/img ke public/uploads/setting
//----- supaya tampilan awal aplikasi tidak berubah
class SettingSeeder extends Seeder
{
    public function run(): void
    {
        //----- Siapkan folder penyimpanan file setting
        $folder = public_path('uploads/setting');
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        //----- Salin gambar default ke folder uploads agar bisa diatur lewat halaman Setting
        $logoDefault = 'logo-default.jpeg';
        $ikonDefault = 'ikon-default.svg';

        if (!file_exists($folder . '/' . $logoDefault)) {
            copy(public_path('assets/img/download (1).jpeg'), $folder . '/' . $logoDefault);
        }
        if (!file_exists($folder . '/' . $ikonDefault)) {
            copy(public_path('assets/img/motor-logo.svg'), $folder . '/' . $ikonDefault);
        }

        //----- Isi data setting baris pertama; kalau sudah ada, pakai data yang ada
        $setting = Setting::first();
        if ($setting === null) {
            Setting::create([
                'nama_usaha' => 'Bengkel Pintar',
                'nama_owner' => 'Admin',
                'alamat' => 'Jl. Raya Bengkel No. 1',
                'logo' => $logoDefault,
                'ikon' => $ikonDefault,
            ]);
        }
    }
}
