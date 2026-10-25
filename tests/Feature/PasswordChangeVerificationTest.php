<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PasswordChangeVerificationTest extends TestCase
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

    private function makeUser(int $role): User
    {
        $user = User::create([
            'nama'                 => 'QA User ' . $role,
            'username'             => 'qa-' . $role . '-' . uniqid(),
            'email'                => 'qa-' . $role . '-' . uniqid() . '@example.com',
            'password'             => Hash::make('oldpassword123'),
            'id_role'              => $role,
            'status'               => 'aktif',
            'must_change_password' => false,
        ]);

        $this->created[] = $user;

        return $user;
    }

    /**
     * Admin (role 2) wajib memasukkan password lama untuk mengganti password
     */
    public function test_admin_change_password_requires_old_password(): void
    {
        $admin = $this->makeUser(2);

        // 1. Gagal jika tanpa password lama
        $resWithoutOld = $this->actingAs($admin)->put(route('admin.profil.update'), [
            'nama'                  => $admin->nama,
            'email'                 => $admin->email,
            'password'              => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);
        $resWithoutOld->assertSessionHasErrors('password_lama');

        // 2. Gagal jika password lama salah
        $resWrongOld = $this->actingAs($admin)->put(route('admin.profil.update'), [
            'nama'                  => $admin->nama,
            'email'                 => $admin->email,
            'password_lama'         => 'wrongpassword',
            'password'              => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);
        $resWrongOld->assertSessionHasErrors('password_lama');

        // 3. Berhasil jika password lama benar
        $resSuccess = $this->actingAs($admin)->put(route('admin.profil.update'), [
            'nama'                  => $admin->nama,
            'email'                 => $admin->email,
            'password_lama'         => 'oldpassword123',
            'password'              => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);
        $resSuccess->assertRedirect(route('admin.profil'));
        $resSuccess->assertSessionHas('success');

        $admin->refresh();
        $this->assertTrue(Hash::check('newpassword123', $admin->password));
    }

    /**
     * Super Admin (role 1) wajib memasukkan current_password untuk mengganti password
     */
    public function test_superadmin_change_password_requires_old_password(): void
    {
        $superadmin = $this->makeUser(1);

        // 1. Gagal jika tanpa password lama
        $resWithoutOld = $this->actingAs($superadmin)->post(route('update.password'), [
            'new_password'              => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);
        $resWithoutOld->assertSessionHasErrors('current_password');

        // 2. Gagal jika password lama salah
        $resWrongOld = $this->actingAs($superadmin)->post(route('update.password'), [
            'current_password'          => 'wrongpassword',
            'new_password'              => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);
        $resWrongOld->assertSessionHasErrors('current_password');

        // 3. Berhasil jika password lama benar
        $resSuccess = $this->actingAs($superadmin)->post(route('update.password'), [
            'current_password'          => 'oldpassword123',
            'new_password'              => 'newpassword123',
            'new_password_confirmation' => 'newpassword123',
        ]);
        $resSuccess->assertSessionHas('success');

        $superadmin->refresh();
        $this->assertTrue(Hash::check('newpassword123', $superadmin->password));
    }

    /**
     * Siswa (role 3) wajib memasukkan password_lama untuk mengganti password
     */
    public function test_siswa_change_password_requires_old_password(): void
    {
        $siswa = $this->makeUser(3);

        // 1. Gagal jika tanpa password lama
        $resWithoutOld = $this->actingAs($siswa)->post(route('siswa.profil.password'), [
            'password_baru'              => 'newpassword123',
            'password_baru_confirmation' => 'newpassword123',
        ]);
        $resWithoutOld->assertSessionHasErrors('password_lama');

        // 2. Gagal jika password lama salah
        $resWrongOld = $this->actingAs($siswa)->post(route('siswa.profil.password'), [
            'password_lama'              => 'wrongpassword',
            'password_baru'              => 'newpassword123',
            'password_baru_confirmation' => 'newpassword123',
        ]);
        $resWrongOld->assertSessionHasErrors('password_lama');

        // 3. Berhasil jika password lama benar
        $resSuccess = $this->actingAs($siswa)->post(route('siswa.profil.password'), [
            'password_lama'              => 'oldpassword123',
            'password_baru'              => 'newpassword123',
            'password_baru_confirmation' => 'newpassword123',
        ]);
        $resSuccess->assertRedirect(route('siswa.profil'));
        $resSuccess->assertSessionHas('success');

        $siswa->refresh();
        $this->assertTrue(Hash::check('newpassword123', $siswa->password));
    }

    /**
     * Halaman profil Siswa dan Admin menampilkan informasi statis dan tidak memiliki form ubah password
     */
    public function test_profile_pages_display_static_superadmin_contact_message(): void
    {
        $siswa = $this->makeUser(3);
        $resSiswa = $this->actingAs($siswa)->get(route('siswa.profil'));
        $resSiswa->assertOk();
        $resSiswa->assertSee('Jika ingin mengubah password, silakan hubungi Super Admin.');
        $resSiswa->assertDontSee('id="form-password"', false);

        $admin = $this->makeUser(2);
        $resAdmin = $this->actingAs($admin)->get(route('admin.profil'));
        $resAdmin->assertOk();
        $resAdmin->assertSee('Jika ingin mengubah password, silakan hubungi Super Admin.');
        $resAdmin->assertDontSee('name="password_lama"', false);
    }

    /**
     * Force Password Change hanya berlaku untuk role Siswa, bukan Admin Divisi
     */
    public function test_force_password_change_only_targets_siswa(): void
    {
        // 1. Siswa dengan must_change_password = true diarahkan ke /ganti-password
        $siswa = $this->makeUser(3);
        $siswa->must_change_password = true;
        $siswa->save();

        $resSiswa = $this->actingAs($siswa)->get(route('siswa.dashboard'));
        $resSiswa->assertRedirect(route('change.password'));

        // 2. Admin Divisi TIDAK diarahkan ke /ganti-password (bahkan jika flag bernilai true)
        $admin = $this->makeUser(2);
        $admin->must_change_password = true;
        $admin->save();

        $resAdmin = $this->actingAs($admin)->get(route('admin.dashboard'));
        $resAdmin->assertOk();
    }
}
