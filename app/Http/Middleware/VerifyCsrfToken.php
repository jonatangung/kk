<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

//--- Middleware bawaan Laravel: memverifikasi token CSRF pada request POST/PUT/DELETE agar mencegah serangan CSRF.
//--- Dipakai otomatis oleh semua route yang memakai middleware group 'web' (didaftarkan di app/Http/Kernel.php baris 37),
//--- jadi hampir semua halaman form dan request dari Blade/view. Token CSRF dikirim lewat directive @csrf di form Blade;
//--- jika URI ada di $except, pengecekannya dilewati.
class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    //--- Daftar route/URI yang dikecualikan dari pengecekan token CSRF (kosongkan jika semua dicek)
    protected $except = [
        //
    ];
}
