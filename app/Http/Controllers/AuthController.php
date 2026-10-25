<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Role ID siswa. Hanya siswa yang wajib ganti password pada login pertama.
     */
    private const ROLE_SISWA = 3;

    private static ?bool $hasLastLoginColumn = null;

    /**
     * Cek apakah kolom users.last_login_at tersedia (dengan cache per request).
     */
    private static function hasLastLoginColumn(): bool
    {
        if (self::$hasLastLoginColumn === null) {
            self::$hasLastLoginColumn = Schema::hasColumn('users', 'last_login_at');
        }

        return self::$hasLastLoginColumn;
    }

    /**
     * Tampilkan halaman login
     */
    public function showLogin()
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user && !empty($user->status) && strtolower(trim((string) $user->status)) === 'nonaktif') {
                Auth::logout();
                request()->session()->invalidate();
                request()->session()->regenerateToken();
            }
        }

        return view('auth.login');
    }

    /**
     * Proses login
     */
    public function login(Request $request)
    {
        // 1. Validasi Input (Email & Password)
        $credentials = $request->validate([
            'email'    => 'required|string',
            'password' => 'required|string',
        ], [
            'email.required'    => 'Email wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loginRaw   = (string) $credentials['email'];
        $loginInput = trim($loginRaw);
        $password   = (string) $credentials['password'];

        // 2. Temukan User secara presisi berdasarkan Email ATAU Username
        $user = User::where('email', $loginInput)
            ->orWhere('username', $loginInput)
            ->orWhereRaw('LOWER(email) = ?', [strtolower($loginInput)])
            ->orWhereRaw('LOWER(username) = ?', [strtolower($loginInput)])
            ->first();

        // 3. Jika user tidak ditemukan
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ])->withInput($request->only('email'));
        }

        // 4. Proteksi Status Akun: Tolak langsung jika akun dinonaktifkan oleh Super Admin
        if (strtolower(trim((string) ($user->status ?? 'aktif'))) === 'nonaktif') {
            return back()->withErrors([
                'email' => 'Akun Anda sedang dinonaktifkan oleh Super Admin. Silakan hubungi Super Admin untuk mengaktifkan kembali akun Anda.',
            ])->withInput($request->only('email'));
        }

        // 5. Verifikasi Password secara presisi & aman (hanya password aktual yang cocok)
        if (!Hash::check($password, $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ])->withInput($request->only('email'));
        }

        // 6. Login user dan regenerasi session
        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        // Catat waktu login terakhir
        if (self::hasLastLoginColumn()) {
            $user->forceFill(['last_login_at' => now()])->saveQuietly();
        }

        // 7. Cek Flag Ganti Password (First Login)
        // HANYA siswa (id_role = 3) yang wajib ganti password saat login pertama jika must_change_password aktif
            if ((int) $user->id_role === self::ROLE_SISWA && !empty($user->must_change_password)) {
                return redirect()->route('change.password')->with('warning', '⚠️ Ini adalah login pertama Anda. Silakan ganti password.');
            }

            // 5. Redirect Berdasarkan Role
            $targetUrl = match ((int) $user->id_role) {
                1 => route('superadmin.dashboard'),
                2 => route('admin.dashboard'),
                default => route('siswa.dashboard'),
            };

            // Bersihkan url.intended jika:
            // a. Menunjuk ke route autentikasi (login, logout, change-password)
            // b. Menunjuk ke URL dashboard peran lain (mencegah error 403 Forbidden!)
            $intended = (string) $request->session()->get('url.intended', '');
            if ($intended !== '') {
                $path = parse_url($intended, PHP_URL_PATH) ?? '';

                $isAuthRoute = str_contains($path, '/login') || 
                               str_contains($path, '/logout') || 
                               str_contains($path, '/change-password');

                $isRoleCompatible = match ((int) $user->id_role) {
                    1 => str_starts_with($path, '/superadmin') || $path === '/',
                    2 => str_starts_with($path, '/admin') && !str_starts_with($path, '/superadmin'),
                    3 => str_starts_with($path, '/siswa'),
                    default => false,
                };

                if ($isAuthRoute || !$isRoleCompatible) {
                    $request->session()->forget('url.intended');
                    return redirect()->to($targetUrl);
                }

                return redirect()->intended($targetUrl);
            }

            return redirect()->to($targetUrl);
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
     * Tampilkan halaman ganti password
     */
    public function showChangePassword()
    {
        return view('auth.change-password');
    }

    /**
     * Proses update password
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password lama wajib dimasukkan terlebih dahulu.',
            'new_password.required'     => 'Password baru wajib diisi.',
            'new_password.min'          => 'Password baru minimal 6 karakter.',
            'new_password.confirmed'    => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama tidak sesuai.']);
        }

        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'Password baru tidak boleh sama dengan yang lama.']);
        }

        $user->password = Hash::make($request->new_password);

        // Reset flag jika ada
        if (isset($user->must_change_password)) {
            $user->must_change_password = 0;
        }

        $user->save();

        // Redirect sesuai konteks pemanggilan
        if (url()->previous() === route('change.password')) {
            if ($user->id_role == 1) return redirect()->route('superadmin.dashboard')->with('success', 'Password diubah!');
            if ($user->id_role == 2) return redirect()->route('admin.dashboard')->with('success', 'Password diubah!');
            return redirect()->route('siswa.dashboard')->with('success', 'Password diubah!');
        }

        return back()->with('success', 'Password berhasil diubah!');
    }
}
