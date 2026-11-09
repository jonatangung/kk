<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

//--- Middleware bawaan Laravel: fungsi untuk menolak request saat aplikasi dalam mode maintenance
//--- Dipakai oleh SEMUA request karena didaftarkan di $middleware (global) di app/Http/Kernel.php baris 20.
//--- File terkait: semua route di routes/web.php. Jika ada URI yang boleh diakses saat maintenance, isi $except.
class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array<int, string>
     */
    //--- Daftar route/URI yang tetap bisa diakses saat mode maintenance aktif (kosongkan jika semua ditolak)
    protected $except = [
        //
    ];
}
