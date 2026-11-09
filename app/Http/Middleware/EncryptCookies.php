<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

//--- Middleware bawaan Laravel: fungsi untuk mengenkripsi semua cookie yang dikirim ke browser
//--- Dipakai oleh semua route yang masuk middleware group 'web' (didaftarkan di app/Http/Kernel.php baris 33),
//--- yaitu SEMUA route di routes/web.php (login, pelanggan, kendaraan, servis, dll) karena memakai session/cookie login.
//--- File terkait: semua halaman Blade di resources/views/ dan semua controller di app/Http/Controllers/.
class EncryptCookies extends Middleware
{
    /**
     * The names of the cookies that should not be encrypted.
     *
     * @var array<int, string>
     */
    //--- Daftar nama cookie yang TIDAK perlu dienkripsi (kosongkan jika semua dienkripsi)
    protected $except = [
        //
    ];
}
