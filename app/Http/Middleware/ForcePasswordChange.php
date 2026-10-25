<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForcePasswordChange
{
    /**
     * Role ID siswa. Hanya siswa yang WAJIB ganti password pada login pertama.
     * Super Admin (1) & Admin Divisi (2) tidak dipaksa.
     */
    private const ROLE_SISWA = 3;

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // HANYA siswa dengan flag must_change_password = true yang dipaksa
        if ($user && (int) $user->id_role === self::ROLE_SISWA && !empty($user->must_change_password)) {

            // Izinkan akses ke route yang berkaitan dengan ganti password & logout
            $allowedRoutes = [
                'change.password',
                'update.password',
                'logout',
            ];

            if (!in_array($request->route()?->getName(), $allowedRoutes, true)) {
                return redirect()->route('change.password')
                    ->with('warning', '⚠️ Ini adalah login pertama Anda. Silakan ganti password untuk keamanan akun.');
            }
        }

        return $next($request);
    }
}
