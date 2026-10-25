<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class RoleSecurityMiddlewareTest extends TestCase
{
    protected User $superadmin;
    protected User $admin;
    protected User $siswa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->superadmin = User::where('id_role', 1)->first() ?? User::factory()->create([
            'id_role'              => 1,
            'must_change_password' => 0,
            'status'               => 'aktif',
        ]);

        $this->admin = User::where('id_role', 2)->first() ?? User::factory()->create([
            'id_role'              => 2,
            'must_change_password' => 0,
            'status'               => 'aktif',
        ]);

        $this->siswa = User::where('id_role', 3)->first() ?? User::factory()->create([
            'id_role'              => 3,
            'must_change_password' => 0,
            'status'               => 'aktif',
        ]);

        // Pastikan siswa tidak tertahan di change-password saat pengujian akses
        $this->siswa->forceFill(['must_change_password' => 0])->saveQuietly();
    }

    public function test_siswa_tidak_bisa_mengakses_bagian_superadmin(): void
    {
        $superadminRoutes = [
            '/superadmin/dashboard',
            '/superadmin/siswa',
            '/superadmin/admin-divisi',
            '/superadmin/settings',
            '/superadmin/profile',
        ];

        foreach ($superadminRoutes as $uri) {
            $response = $this->actingAs($this->siswa)->get($uri);
            $response->assertStatus(403);
            $response->assertSee('403');
            $response->assertSee('Akses Dibatasi');
        }
    }

    public function test_siswa_tidak_bisa_mengakses_bagian_admin(): void
    {
        $adminRoutes = [
            '/admin/dashboard',
            '/admin/materi',
            '/admin/quiz',
            '/admin/bab',
            '/admin/kategori',
            '/admin/monitoring-siswa',
            '/admin/profil',
        ];

        foreach ($adminRoutes as $uri) {
            $response = $this->actingAs($this->siswa)->get($uri);
            $response->assertStatus(403);
            $response->assertSee('403');
            $response->assertSee('Akses Dibatasi');
        }
    }

    public function test_admin_divisi_tidak_bisa_mengakses_bagian_superadmin(): void
    {
        $response = $this->actingAs($this->admin)->get('/superadmin/dashboard');
        $response->assertStatus(403);
        $response->assertSee('403');

        $responseSiswaManage = $this->actingAs($this->admin)->get('/superadmin/siswa');
        $responseSiswaManage->assertStatus(403);
    }

    public function test_admin_divisi_tidak_bisa_mengakses_bagian_siswa(): void
    {
        $response = $this->actingAs($this->admin)->get('/siswa/dashboard');
        $response->assertStatus(403);
        $response->assertSee('403');
    }

    public function test_superadmin_tidak_bisa_mengakses_bagian_admin(): void
    {
        $dashRes = $this->actingAs($this->superadmin)->get('/admin/dashboard');
        $dashRes->assertStatus(403);
        $dashRes->assertSee('403');

        $admRes = $this->actingAs($this->superadmin)->get('/admin/materi');
        $admRes->assertStatus(403);
        $admRes->assertSee('403');
    }

    public function test_superadmin_tidak_bisa_mengakses_bagian_siswa(): void
    {
        $response = $this->actingAs($this->superadmin)->get('/siswa/dashboard');
        $response->assertStatus(403);
        $response->assertSee('403');
    }

    public function test_superadmin_dapat_mengakses_bagian_superadmin(): void
    {
        $saRes = $this->actingAs($this->superadmin)->get('/superadmin/dashboard');
        $saRes->assertStatus(200);
    }

    public function test_admin_divisi_dapat_mengakses_bagian_admin(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');
        $response->assertStatus(200);

        $materiRes = $this->actingAs($this->admin)->get('/admin/materi');
        $materiRes->assertStatus(200);
    }

    public function test_siswa_dapat_mengakses_bagian_siswa(): void
    {
        $response = $this->actingAs($this->siswa)->get('/siswa/dashboard');
        $response->assertStatus(200);

        $materiRes = $this->actingAs($this->siswa)->get('/siswa/materi');
        $materiRes->assertStatus(200);
    }

    public function test_role_helper_methods_di_model_user(): void
    {
        $this->assertTrue($this->superadmin->isSuperAdmin());
        $this->assertFalse($this->superadmin->isAdmin());
        $this->assertFalse($this->superadmin->isSiswa());
        $this->assertTrue($this->superadmin->hasRole('superadmin'));

        $this->assertFalse($this->admin->isSuperAdmin());
        $this->assertTrue($this->admin->isAdmin());
        $this->assertFalse($this->admin->isSiswa());
        $this->assertTrue($this->admin->hasRole('admin'));

        $this->assertFalse($this->siswa->isSuperAdmin());
        $this->assertFalse($this->siswa->isAdmin());
        $this->assertTrue($this->siswa->isSiswa());
        $this->assertTrue($this->siswa->hasRole('siswa'));
    }
}
