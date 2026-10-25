<?php

namespace Tests\Feature;

use App\Models\Materi;
use App\Models\User;
use Tests\TestCase;

class MateriPreviewAndEyeToggleTest extends TestCase
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

        $this->siswa = User::where('id_role', 3)->where('must_change_password', 0)->first() ?? User::factory()->create([
            'id_role'              => 3,
            'must_change_password' => 0,
            'status'               => 'aktif',
        ]);
        $this->siswa->must_change_password = 0;
        $this->siswa->saveQuietly();
    }

    public function test_admin_materi_page_contains_pov_preview_elements(): void
    {
        $response = $this->actingAs($this->admin)
            ->get('/admin/materi');

        $response->assertStatus(200);
        $response->assertSee('POV');
        $response->assertSee('previewPovModal');
        $response->assertSee('openPreviewPOV');
        $response->assertSee('btnDeviceDesktop');
        $response->assertSee('btnDeviceMobile');
        $response->assertDontSee('btnOpenFullPage');
        $response->assertDontSee('Halaman Penuh');
    }

    public function test_fullpage_preview_route_does_not_exist(): void
    {
        $materi = Materi::first();
        if (!$materi) {
            $this->markTestSkipped('Tidak ada materi di database.');
        }

        $response = $this->actingAs($this->superadmin)
            ->get("/admin/materi/{$materi->id_materi}/preview");

        $response->assertStatus(404);
    }

    public function test_password_eye_toggle_script_is_present_on_auth_and_layouts(): void
    {
        // Login page
        $loginRes = $this->get('/login');
        $loginRes->assertStatus(200);
        $loginRes->assertSee('togglePassword');

        // Admin layout contains universal password toggle enhancer
        $adminRes = $this->actingAs($this->admin)->get('/admin/profil');
        $adminRes->assertStatus(200);
        $adminRes->assertSee('initAllPasswordToggles');

        // Siswa layout contains universal password toggle enhancer
        $siswaRes = $this->actingAs($this->siswa)->get('/siswa/profil');
        $siswaRes->assertStatus(200);
        $siswaRes->assertSee('initAllPasswordToggles');
    }
}
