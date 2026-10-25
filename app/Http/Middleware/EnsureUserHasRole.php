<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasRole
{
    /**
     * Role ID Constants
     * 1 = Super Admin
     * 2 = Admin Divisi
     * 3 = Siswa
     */
    public const ROLE_SUPERADMIN = 1;
    public const ROLE_ADMIN = 2;
    public const ROLE_SISWA = 3;

    /**
     * Mapping nama peran fleksibel (case-insensitive)
     */
    protected static array $roleMap = [
        'superadmin'    => self::ROLE_SUPERADMIN,
        'super_admin'   => self::ROLE_SUPERADMIN,
        'super-admin'   => self::ROLE_SUPERADMIN,
        'admin'         => self::ROLE_ADMIN,
        'admin_divisi'  => self::ROLE_ADMIN,
        'admin-divisi'  => self::ROLE_ADMIN,
        'siswa'         => self::ROLE_SISWA,
        'student'       => self::ROLE_SISWA,
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Wajib terotentikasi
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Unauthenticated.',
                ], 401);
            }
            return redirect()->route('login');
        }

        $user = Auth::user();
        if ($user && !empty($user->status) && strtolower(trim((string)$user->status)) === 'nonaktif') {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Akun Anda telah dinonaktifkan oleh Super Admin.',
                ], 403);
            }

            return redirect()->route('login')->withErrors([
                'email' => 'Sesi Anda berakhir karena akun Anda telah dinonaktifkan oleh Super Admin.',
            ]);
        }

        $userRoleId = (int) $user->id_role;

        // 2. Parse role yang diizinkan (mendukung role:superadmin,admin atau role:1,2)
        $allowedRoleIds = [];
        foreach ($roles as $role) {
            $parts = explode(',', (string) $role);
            foreach ($parts as $part) {
                $key = strtolower(trim($part));
                if (is_numeric($key)) {
                    $allowedRoleIds[] = (int) $key;
                } elseif (isset(self::$roleMap[$key])) {
                    $allowedRoleIds[] = self::$roleMap[$key];
                }
            }
        }

        // 3. Cek apakah user memiliki hak akses
        if (!empty($allowedRoleIds) && !in_array($userRoleId, $allowedRoleIds, true)) {
            if ($request->expectsJson()) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Akses ditolak. Anda tidak memiliki izin untuk mengakses resource ini.',
                ], 403);
            }

            abort(403, 'Akses ditolak. Halaman ini hanya dapat diakses oleh peran yang berwenang.');
        }

        return $next($request);
    }
}
