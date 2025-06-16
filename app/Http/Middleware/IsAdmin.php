<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Penting untuk memanggil Auth
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kita cek: Apakah ada yang sedang login melalui guard 'web'?
        // Karena kita sudah atur di config/auth.php, guard 'web' ini merujuk ke tabel 'admins'.
        if (Auth::guard('web')->check()) {
            // Jika ada admin yang login, izinkan permintaan untuk melanjutkan.
            return $next($request);
        }

        // Jika tidak ada admin yang login, tolak permintaan dengan pesan error 403.
        abort(403, 'ANDA TIDAK MEMILIKI HAK AKSES.');
    }
}