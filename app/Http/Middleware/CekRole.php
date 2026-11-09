<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekRole
{
    /**
     * Handle an incoming request.
     *
     * Parameter route: ->middleware('role:owner,admin')
     * Memeriksa session('role') terhadap daftar role yang diizinkan.
     */
    //--- Fungsi: menangani request yang melewati middleware ini
    //--- $roles berisi daftar role yang boleh mengakses route (misal: 'role:owner,admin')
    //--- Dipakai di routes/web.php lewat alias 'role' (didaftarkan di app/Http/Kernel.php baris 60).
    //--- Contoh: Route::middleware('role:owner,admin')->group(...) untuk menu mekanik, pelanggan, servis, dll.
    public function handle(Request $request, Closure $next, string ...$roles)
    {
        //--- Cek apakah user sudah login (ada session('u'))
        if (!session('u')) {
            return redirect('/'); //--- Belum login, arahkan ke halaman login
        }

        //--- Cek apakah role user ada dalam daftar role yang diizinkan
        if (!in_array(session('role'), $roles, true)) {
            return redirect('/home'); //--- Role tidak sesuai, arahkan ke halaman home
        }

        return $next($request); //--- Role valid, lanjutkan request ke controller
    }
}
