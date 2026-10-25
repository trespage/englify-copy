<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    /** @var User[] */
    private array $created = [];

    protected function tearDown(): void
    {
        foreach ($this->created as $user) {
            User::where('id_user', $user->id_user)->delete();
        }
        $this->created = [];

        parent::tearDown();
    }

    private function makeUser(int $role, bool $mustChangePassword): User
    {
        $user = User::create([
            'nama'               => 'QA User ' . $role,
            'username'           => 'qa-' . $role . '-' . uniqid(),
            'email'              => 'qa-' . $role . '-' . uniqid() . '@example.com',
            'password'           => Hash::make('password123'),
            'id_role'            => $role,
            'status'             => 'aktif',
            'must_change_password' => $mustChangePassword,
        ]);

        $this->created[] = $user;

        return $user;
    }

    public function test_login_admin_divisi_masuk_dashboard_tanpa_error(): void
    {
        $admin = $this->makeUser(2, false);

        $res = $this->post(route('login.proses'), [
            'email'    => $admin->email,
            'password' => 'password123',
        ]);
        $res->assertRedirect(route('admin.dashboard'));

        $dash = $this->actingAs($admin)->get(route('admin.dashboard'));
        $dash->assertOk();
    }

    public function test_login_superadmin_tetap_berfungsi(): void
    {
        $superadmin = $this->makeUser(1, false);

        $this->post(route('login.proses'), [
            'email'    => $superadmin->email,
            'password' => 'password123',
        ])->assertRedirect(route('superadmin.dashboard'));
    }

    public function test_login_siswa_tetap_berfungsi(): void
    {
        $siswa = $this->makeUser(3, false);

        $this->post(route('login.proses'), [
            'email'    => $siswa->email,
            'password' => 'password123',
        ])->assertRedirect(route('siswa.dashboard'));
    }

    public function test_admin_tidak_dipaksa_ganti_password_saat_login(): void
    {
        $admin = $this->makeUser(2, true);

        // Admin TIDAK boleh diarahkan ke halaman ganti password
        $this->post(route('login.proses'), [
            'email'    => $admin->email,
            'password' => 'password123',
        ])->assertRedirect(route('admin.dashboard'));

        // Middleware juga tidak boleh memaksa admin
        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
    }

    public function test_superadmin_tidak_dipaksa_ganti_password_saat_login(): void
    {
        $superadmin = $this->makeUser(1, true);

        $this->post(route('login.proses'), [
            'email'    => $superadmin->email,
            'password' => 'password123',
        ])->assertRedirect(route('superadmin.dashboard'));
    }

    public function test_siswa_dipaksa_ganti_password_pada_login_pertama(): void
    {
        $siswa = $this->makeUser(3, true);

        $this->post(route('login.proses'), [
            'email'    => $siswa->email,
            'password' => 'password123',
        ])->assertRedirect(route('change.password'));

        // Middleware juga mengalihkan akses halaman siswa
        $this->actingAs($siswa)->get(route('siswa.dashboard'))
            ->assertRedirect(route('change.password'));

        // Halaman ganti password sendiri harus tetap bisa diakses
        $this->actingAs($siswa)->get(route('change.password'))->assertOk();
    }

    public function test_admin_baru_dibuat_superadmin_tidak_wajib_ganti_password(): void
    {
        $superadmin = $this->makeUser(1, false);
        $email = 'qa-admin-baru-' . uniqid() . '@example.com';

        $this->actingAs($superadmin)->post(route('superadmin.adminDivisi.store'), [
            'nama'     => 'QA Admin Baru',
            'email'    => $email,
            'password' => 'password123',
            'status'   => 'aktif',
        ])->assertRedirect(route('superadmin.adminDivisi'));

        $admin = User::where('email', $email)->firstOrFail();
        $this->created[] = $admin;

        $this->assertFalse((bool) $admin->must_change_password);
    }

    public function test_siswa_baru_dibuat_superadmin_wajib_ganti_password(): void
    {
        $superadmin = $this->makeUser(1, false);
        $email = 'qa-siswa-baru-' . uniqid() . '@example.com';

        $this->actingAs($superadmin)->post(route('superadmin.siswa.store'), [
            'nama'     => 'QA Siswa Baru',
            'email'    => $email,
            'password' => 'password123',
        ])->assertRedirect(route('superadmin.siswa'));

        $siswa = User::where('email', $email)->firstOrFail();
        $this->created[] = $siswa;

        $this->assertTrue((bool) $siswa->must_change_password);
    }
}
