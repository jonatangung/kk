<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

//--- Middleware bawaan Laravel: fungsi untuk mempercayai proxy (misal load balancer) agar IP asli client terbaca
//--- Dipakai oleh SEMUA request ke aplikasi ini karena didaftarkan di $middleware (global) di app/Http/Kernel.php baris 18.
//--- File terkait: semua route di routes/web.php dan semua controller di app/Http/Controllers/.
class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    //--- Daftar IP proxy yang dipercaya (kosongkan jika tidak memakai proxy)
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
