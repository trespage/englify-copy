<?php

namespace App\Http\Controllers\superadmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Kategori;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SuperAdminController extends Controller
{
    /**
     * Redirect kembali ke halaman asal (dashboard / kelola akun).
     * Jadi kalau edit/hapus dari dashboard ya tetap di dashboard,
     * kalau dari halaman kelola ya tetap di sana.
     * Data tetap sinkron karena sumbernya satu tabel users.
     */
    private function redirectStay(string $fallbackRoute, string $message)
    {
        $previous = url()->previous();
        $fallback = route($fallbackRoute);

        if ($previous && $previous !== $fallback) {
            // Hanya izinkan redirect internal area superadmin (cegah open redirect)
            $prevPath = parse_url($previous, PHP_URL_PATH) ?? '';
            if (str_contains($prevPath, '/superadmin')) {
                // Kalau dari dashboard, tambahkan anchor biar langsung scroll ke tabel kelola akun
                if (str_contains($prevPath, '/superadmin/dashboard') && !str_contains($previous, '#')) {
                    $previous .= '#tabel-kelola-akun';
                }
                return redirect()->to($previous)->with('success', $message);
            }
        }

        return redirect()->route($fallbackRoute)->with('success', $message);
    }

    public function index()
    {
        // Hitung total statistik untuk card di dashboard (data real dari database)
        $totalSiswa = User::where('id_role', 3)->count();
        $totalAdmin = User::where('id_role', 2)->count();
        $totalDivisi = Kategori::count();

        // Ambil data siswa dan admin terbaru (misal 5 data terakhir) untuk ditampilkan di tabel dashboard
        $students = User::where('id_role', 3)->latest()->take(5)->get();
        $admins = User::where('id_role', 2)->latest()->take(5)->get();

        $now = now();
        $startThisMonth = $now->copy()->startOfMonth();
        $startLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endLastMonth = $startThisMonth->copy()->subSecond();

        // Pertumbuhan bulan ini vs bulan lalu (untuk badge card)
        $siswaThisMonth = User::where('id_role', 3)->where('created_at', '>=', $startThisMonth)->count();
        $siswaLastMonth = User::where('id_role', 3)->whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();
        $adminThisMonth = User::where('id_role', 2)->where('created_at', '>=', $startThisMonth)->count();
        $adminLastMonth = User::where('id_role', 2)->whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();
        $divisiThisMonth = Kategori::where('created_at', '>=', $startThisMonth)->count();
        $divisiLastMonth = Kategori::whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();
        // Cakupan akun yang dikelola (siswa + admin, tanpa superadmin)
        $managedThisMonth = User::whereIn('id_role', [2, 3])->where('created_at', '>=', $startThisMonth)->count();
        $managedLastMonth = User::whereIn('id_role', [2, 3])->whereBetween('created_at', [$startLastMonth, $endLastMonth])->count();

        $siswaGrowth = $this->monthGrowth($siswaThisMonth, $siswaLastMonth);
        $adminGrowth = $this->monthGrowth($adminThisMonth, $adminLastMonth);
        $divisiGrowth = $this->monthGrowth($divisiThisMonth, $divisiLastMonth);
        $divisiTrend = $this->trendBadge($divisiThisMonth, $divisiLastMonth);

        // Ringkasan: akun baru 7 hari terakhir vs 7 hari sebelumnya
        $weekAgo = $now->copy()->subDays(7);
        $twoWeeksAgo = $now->copy()->subDays(14);
        $newSiswaCount = User::where('id_role', 3)->where('created_at', '>=', $weekAgo)->count();
        $prevSiswaCount = User::where('id_role', 3)->whereBetween('created_at', [$twoWeeksAgo, $weekAgo])->count();
        $newAdminCount = User::where('id_role', 2)->where('created_at', '>=', $weekAgo)->count();
        $prevAdminCount = User::where('id_role', 2)->whereBetween('created_at', [$twoWeeksAgo, $weekAgo])->count();
        $newSiswaGrowth = $this->trendBadge($newSiswaCount, $prevSiswaCount);
        $newAdminGrowth = $this->trendBadge($newAdminCount, $prevAdminCount);

        $activeAccounts = User::whereIn('id_role', [2, 3])->where('status', 'aktif')->count();
        $activeGrowth = $this->trendBadge($managedThisMonth, $managedLastMonth);

        $totalAkun = User::whereIn('id_role', [2, 3])->count();
        $totalAkunGrowth = $this->trendBadge($managedThisMonth, $managedLastMonth);

        // Grafik pertumbuhan siswa 7 hari terakhir (kumulatif)
        $windowStart = $now->copy()->subDays(6)->startOfDay();
        $perDay = User::where('id_role', 3)->where('created_at', '>=', $windowStart)
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->groupBy('d')
            ->pluck('c', 'd');
        $base = User::where('id_role', 3)->where('created_at', '<', $windowStart)->count();
        $chartLabels = [];
        $chartData = [];
        $running = $base;
        for ($i = 6; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $running += (int) ($perDay[$day->format('Y-m-d')] ?? 0);
            $chartLabels[] = $day->format('j M');
            $chartData[] = $running;
        }
        $peak = !empty($chartData) ? max($chartData) : 0;
        $chartMax = $peak <= 0 ? 10 : (int) (ceil(($peak * 1.2) / 10) * 10);
        $chartStep = max(1, (int) round($chartMax / 5));

        // Aktivitas terbaru: 5 akun siswa/admin yang paling baru dibuat
        $recentActivities = User::whereIn('id_role', [2, 3])->latest()->take(5)->get()->map(function ($u) {
            $isAdmin = (int) $u->id_role === 2;
            return (object) [
                'title' => 'Akun baru: ' . $u->nama,
                'desc' => $u->email . ' • ' . ($u->created_at ? $u->created_at->format('d M Y H:i') : '-'),
                'time' => $u->created_at ? $u->created_at->diffForHumans() : '-',
                'role' => $isAdmin ? 'Admin Divisi' : 'Siswa',
                'badge_class' => $isAdmin
                    ? 'bg-violet-50 text-violet-600 border-violet-200'
                    : 'bg-blue-50 text-blue-600 border-blue-200',
            ];
        });

        $systemStatus = 'Normal';

        return view('superadmin.dashboard', compact(
            'totalSiswa', 'totalAdmin', 'totalDivisi', 'students', 'admins',
            'siswaGrowth', 'adminGrowth', 'divisiGrowth', 'divisiTrend',
            'newSiswaCount', 'newAdminCount', 'newSiswaGrowth', 'newAdminGrowth',
            'activeAccounts', 'activeGrowth', 'totalAkun', 'totalAkunGrowth',
            'chartLabels', 'chartData', 'chartMax', 'chartStep',
            'recentActivities', 'systemStatus'
        ));
    }

    /**
     * Persentase perubahan bulan ini vs bulan lalu, format "+ 12%" / "- 3%".
     */
    private function monthGrowth(int $current, int $previous): string
    {
        if ($previous <= 0) {
            return $current > 0 ? '+ 100%' : '+ 0%';
        }
        $p = (int) round(($current - $previous) / $previous * 100);
        return ($p < 0 ? '- ' : '+ ') . abs($p) . '%';
    }

    /**
     * Badge tren untuk ringkasan, format "▲ 20%" / "▼ 5%".
     */
    private function trendBadge(int $current, int $previous): string
    {
        if ($previous <= 0) {
            return $current > 0 ? '▲ 100%' : '▲ 0%';
        }
        $p = (int) round(($current - $previous) / $previous * 100);
        return ($p < 0 ? '▼ ' : '▲ ') . abs($p) . '%';
    }

    public function users()
    {
        return redirect('/superadmin/admin-divisi');
    }

    public function storeUser(Request $request)
    {
        // Modal "Tambah Akun" di dashboard punya pilihan role siswa / admin
        if ($request->input('role') === 'admin') {
            return $this->storeAdminDivisi($request);
        }

        return $this->storeSiswa($request);
    }

    public function updateUser(Request $request, $id)
    {
        // Modal "Edit Akun" di dashboard: arahkan sesuai role asli user
        $user = User::findOrFail($id);

        if ((int) $user->id_role === 2) {
            return $this->updateAdminDivisi($request, $id);
        }

        return $this->updateSiswa($request, $id);
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);

        if ((int) $user->id_role === 2) {
            return $this->destroyAdminDivisi($id);
        }

        return $this->destroySiswa($id);
    }

    // =========================================================
    // KELOLA AKUN SISWA (Role ID = 3)
    // =========================================================
    public function siswa()
    {
        $idRoleSiswa = 3;
        $students = User::where('id_role', $idRoleSiswa)->latest()->paginate(10);
        $totalStudents = User::where('id_role', $idRoleSiswa)->count();

        return view('superadmin.siswa', compact('students', 'totalStudents'));
    }

    public function storeSiswa(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:6',
        ]);

        $idRoleSiswa = 3;

        // Membuat username unik otomatis dari depan email
        $username = Str::slug(explode('@', $request->email)[0]) . '-' . rand(100, 999);

        User::create([
            'nama' => $request->nama,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->input('password') ?: 'password123'),
            'id_role' => $idRoleSiswa,
        ]);

        return $this->redirectStay('superadmin.siswa', 'Akun siswa berhasil ditambahkan! 🐾');
    }

    public function updateSiswa(Request $request, $id)
    {
        $student = User::where('id_role', 3)->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $student->id_user . ',id_user',
            'password' => 'nullable|string|min:6',
        ]);

        $student->nama = $request->nama;
        $student->email = $request->email;

        if ($request->filled('password')) {
            $student->password = Hash::make($request->password);
        }
        $student->save();

        return $this->redirectStay('superadmin.siswa', 'Akun siswa berhasil diperbarui! 🐾');
    }

    public function destroySiswa($id)
    {
        User::where('id_role', 3)->findOrFail($id)->delete();
        return $this->redirectStay('superadmin.siswa', 'Akun siswa berhasil dihapus! 🐾');
    }

    // =========================================================
    // KELOLA ADMIN DIVISI (Role ID = 2)
    // =========================================================
    public function adminDivisi()
    {
        $idRoleAdmin = 2;

        $admins = User::where('id_role', $idRoleAdmin)->latest()->paginate(10);
        $totalAdmins = User::where('id_role', $idRoleAdmin)->count();

        return view('superadmin.admin-divisi', compact('admins', 'totalAdmins'));
    }

    public function storeAdminDivisi(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'nullable|string|min:6',
            'status' => 'nullable|in:aktif,nonaktif',
            'id_kategori' => 'nullable|exists:kategori,id_kategori',
        ]);

        $idRoleAdmin = 2;

        // Membuat username unik otomatis dari depan email
        $username = Str::slug(explode('@', $request->email)[0]) . '-' . rand(100, 999);

        User::create([
            'nama' => $request->nama,
            'username' => $username,
            'email' => $request->email,
            'password' => Hash::make($request->input('password') ?: 'password123'),
            'id_role' => $idRoleAdmin,
            'id_kategori' => $request->input('id_kategori'),
            'status' => $request->input('status', 'aktif'),
        ]);

        return $this->redirectStay('superadmin.adminDivisi', 'Akun admin divisi berhasil ditambahkan! 🐾');
    }

    public function updateAdminDivisi(Request $request, $id)
    {
        $admin = User::where('id_role', 2)->findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $admin->id_user . ',id_user',
            'password' => 'nullable|string|min:6',
            'status' => 'nullable|in:aktif,nonaktif',
            'id_kategori' => 'nullable|exists:kategori,id_kategori',
        ]);

        $admin->nama = $request->nama;
        $admin->email = $request->email;

        if ($request->filled('status')) {
            $admin->status = $request->status;
        }

        if ($request->filled('id_kategori')) {
            $admin->id_kategori = $request->id_kategori;
        }

        if ($request->filled('password')) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        return $this->redirectStay('superadmin.adminDivisi', 'Akun admin divisi berhasil diperbarui! 🐾');
    }

    public function destroyAdminDivisi($id)
    {
        User::where('id_role', 2)->findOrFail($id)->delete();
        return $this->redirectStay('superadmin.adminDivisi', 'Akun admin divisi berhasil dihapus! 🐾');
    }

    // =========================================================
    // HALAMAN LAINNYA (Placeholder View)
    // =========================================================
    public function divisi() { return redirect()->route('superadmin.adminDivisi'); }
    public function settings() { return view('superadmin.settings'); }
    public function profile() { return view('superadmin.profile'); }
}
