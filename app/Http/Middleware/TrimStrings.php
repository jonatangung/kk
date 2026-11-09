<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

//--- Middleware bawaan Laravel: fungsi untuk memangkas spasi/whitespace di awal dan akhir data input
//--- Dipakai oleh SEMUA request karena didaftarkan di $middleware (global) di app/Http/Kernel.php baris 22.
//--- File terkait: semua form di resources/views/*.blade.php dan semua route POST di routes/web.php
//--- (misal login, tambah/edit pelanggan, kendaraan, servis). Field 'password' dikecualikan agar spasi tidak hilang.
class TrimStrings extends Middleware
{
    /**
     * The names of the attributes that should not be trimmed.
     *
     * @var array<int, string>
     */
    //--- Daftar field input yang TIDAK boleh dipangkas (misal: password agar spasi tidak hilang)
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}
