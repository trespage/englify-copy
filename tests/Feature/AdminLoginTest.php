<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    public function test_login_admin_divisi_masuk_dashboard_tanpa_error(): void
    {
        $admin = User::where('id_role', 2)->first();
        $this->assertNotNull($admin, 'Butuh akun admin divisi (id_role=2)');

        // Password akun seed adalah password123
        $res = $this->post(route('login.proses'), [
            'login' => $admin->email,
            'password' => 'password123',
        ]);
        $res->assertRedirect(route('admin.dashboard'));

        $dash = $this->actingAs($admin)->get(route('admin.dashboard'));
        $dash->assertOk();
    }

    public function test_login_superadmin_tetap_berfungsi(): void
    {
        $superadmin = User::where('id_role', 1)->first();
        $this->assertNotNull($superadmin);
        $this->post(route('login.proses'), [
            'login' => $superadmin->email,
            'password' => 'password123',
        ])->assertRedirect(route('superadmin.dashboard'));
    }

    public function test_login_siswa_tetap_berfungsi(): void
    {
        $siswa = User::where('id_role', 3)->first();
        $this->assertNotNull($siswa);
        $this->post(route('login.proses'), [
            'login' => $siswa->email,
            'password' => 'password123',
        ])->assertRedirect(route('siswa.dashboard'));
    }
}
