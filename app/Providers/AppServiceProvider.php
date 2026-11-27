<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //----- Kirim data setting (identitas usaha) ke SEMUA view sekaligus,
        //----- supaya header, login, dll tidak perlu query database berulang kali.
        //----- Di-wrap try/catch: kalau tabel setting belum di-migrate, pakai nilai default.
        View::share('dataSetting', $this->ambilDataSetting());
    }

    //----- mengambil data setting baris pertama, lengkap dengan URL logo & ikon
    private function ambilDataSetting(): array
    {
        //----- Nilai default dipakai kalau tabel kosong atau belum ada datanya
        $data = [
            'nama_usaha' => 'Bengkel Pintar',
            'nama_owner' => '',
            'alamat' => '',
            'logo_url' => asset('assets/img/download (1).jpeg'),
            'ikon_url' => asset('assets/img/motor-logo.svg'),
        ];

        try {
            $setting = Setting::first();

            if ($setting !== null) {
                $data['nama_usaha'] = $setting->nama_usaha;
                $data['nama_owner'] = $setting->nama_owner;
                $data['alamat'] = $setting->alamat;

                //----- Logo: ambil dari uploads/setting kalau file-nya ada
                if ($setting->logo && file_exists(public_path('uploads/setting/' . $setting->logo))) {
                    $data['logo_url'] = asset('uploads/setting/' . $setting->logo);
                }

                //----- Ikon (favicon): ambil dari uploads/setting kalau file-nya ada
                if ($setting->ikon && file_exists(public_path('uploads/setting/' . $setting->ikon))) {
                    $data['ikon_url'] = asset('uploads/setting/' . $setting->ikon);
                }
            }
        } catch (\Throwable $e) {
            //----- Tabel setting belum ada (migration belum jalan) -> pakai default
        }

        return $data;
    }
}
