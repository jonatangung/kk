<?php
//--- Kode PHP untuk aplikasi Laravel

namespace App\Http; //--- Namespace: lokasi class ini berada (App\Http)

use Illuminate\Foundation\Http\Kernel as HttpKernel; //--- Class induk Kernel bawaan Laravel yang di-extend

class Kernel extends HttpKernel //--- Class Kernel kita mewarisi (extends) HttpKernel bawaan Laravel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        //--- Middleware global: jalan di SETIAP request, baik web maupun api

        \App\Http\Middleware\TrustProxies::class, //--- Percaya pada proxy (misal: Nginx/LB) agar Laravel tahu IP asli client
        \Illuminate\Http\Middleware\HandleCors::class, //--- Mengelola CORS: mengizinkan/menolak request dari domain lain (cross-origin)
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class, //--- Menampilkan halaman maintenance saat aplikasi sedang di-maintenance mode
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class, //--- Memvalidasi ukuran request POST agar tidak melebihi batas
        \App\Http\Middleware\TrimStrings::class, //--- Memotong spasi di awal dan akhir input string (trim)
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class, //--- Mengubah string kosong ('') menjadi null di semua input
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        //--- Grup middleware yang bisa dipakai berdasarkan jenis route

        'web' => [
            //--- Middleware yang hanya jalan untuk route web (browser, ada session & cookie)

            \App\Http\Middleware\EncryptCookies::class, //--- Mengenkripsi semua cookie yang dikirim ke browser
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class, //--- Menambahkan cookie yang di-queue ke response sebelum dikirim
            \Illuminate\Session\Middleware\StartSession::class, //--- Memulai session untuk menyimpan data antar request
            \Illuminate\View\Middleware\ShareErrorsFromSession::class, //--- Membagikan error validasi dari session ke semua view (blade)
            \App\Http\Middleware\VerifyCsrfToken::class, //--- Memverifikasi token CSRF untuk mencegah serangan (Cross-Site Request Forgery)
            \Illuminate\Routing\Middleware\SubstituteBindings::class, //--- Mengubah parameter route (misal {id}) menjadi model Eloquent otomatis
        ],

        'api' => [
            //--- Middleware yang hanya jalan untuk route api (tidak pakai session/cookie)

            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class, //--- Sanctum (dipaksa comment/disabled)
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api', //--- Membatasi jumlah request (rate limiting) sesuai preset 'api' di RouteServiceProvider
            \Illuminate\Routing\Middleware\SubstituteBindings::class, //--- Mengubah parameter route menjadi model Eloquent otomatis
        ],
    ];

    /**
     * The application's middleware aliases.
     *
     * Aliases may be used instead of class names to conveniently assign middleware to routes and groups.
     *
     * @var array<string, class-string|string>
     */
    protected $middlewareAliases = [
        //--- Alias (nama pendek) untuk middleware, bisa dipakai di route: 'middleware' => 'alias'

        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class, //--- Autentikasi HTTP Basic Auth (username/password)
        'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class, //--- Memastikan session tetap valid saat user login
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class, //--- Mengatur header cache pada response
        'can' => \Illuminate\Auth\Middleware\Authorize::class, //--- Otorisasi: cek apakah user boleh melakukan aksi tertentu
        'role' => \App\Http\Middleware\CekRole::class, //--- Middleware custom untuk cek role user
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class, //--- Meminta konfirmasi password sebelum melanjutkan aksi
        'precognitive' => \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class, //--- Mendukung fitur precognition (preview validasi sebelum submit)
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class, //--- Membatasi frekuensi request (rate limit) per user/IP
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class, //--- Memastikan email user sudah diverifikasi
    ];
}
