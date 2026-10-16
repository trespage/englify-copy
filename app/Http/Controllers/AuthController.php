<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (auth()->check()) {
            return $this->redirectByRole(auth()->user());
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // ==========================================
        // MODE DEBUG: Hapus bagian ini nanti kalau sudah berhasil!
        // ==========================================
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->login)->first();

        // CEK 1: Apakah email ditemukan?
        if (!$user) {
            return back()->withErrors(['login' => 'DEBUG: Email tidak ditemukan di database.']);
        }

        // CEK 2: Apakah password cocok?
        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['login' => 'DEBUG: Password salah (Hash tidak cocok). Pastikan password di database sudah di-hash.']);
        }

        // CEK 3: Apakah role-nya valid?
        if (!in_array($user->id_role, [1, 2, 3])) {
            return back()->withErrors(['login' => 'DEBUG: Role user tidak valid. Ditemukan role: ' . $user->id_role . ' (Harusnya 1, 2, atau 3)']);
        }
        // ==========================================
        // AKHIR MODE DEBUG
        // ==========================================

        // Jika semua lolos, lakukan login
        Auth::login($user, $request->filled('remember'));
        $request->session()->regenerate();

        // Redirect berdasarkan role
        return $this->redirectByRole($user)->with('success', 'Login berhasil!');
    }

    private function redirectByRole($user)
    {
        if ($user->id_role == 1) {
            return redirect()->route('superadmin.dashboard');
        } elseif ($user->id_role == 2) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->id_role == 3) {
            return redirect()->route('siswa.dashboard');
        }

        return redirect('/login')->withErrors(['login' => 'Role tidak dikenali.']);
    }

    public function showChangePassword()
    {
        if (!auth()->check()) return redirect('/login');
        return view('auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = auth()->user();
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password lama salah.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
            'must_change_password' => false,
        ]);

        return $this->redirectByRole($user)->with('success', 'Password berhasil diperbarui!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'Anda telah logout.');
    }
}
