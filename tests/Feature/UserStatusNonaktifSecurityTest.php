<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserStatusNonaktifSecurityTest extends TestCase
{
    protected ?User $adminNonaktif = null;
    protected ?User $siswaNonaktif = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminNonaktif = User::updateOrCreate(
            ['email' => 'admin_test_nonaktif@englify.com'],
            [
                'nama'     => 'Admin Nonaktif Test',
                'username' => 'admintestnonaktif',
                'password' => Hash::make('password123'),
                'id_role'  => 2,
                'status'   => 'nonaktif',
                'must_change_password' => false,
            ]
        );

        $this->siswaNonaktif = User::updateOrCreate(
            ['email' => 'siswa_test_nonaktif@englify.com'],
            [
                'nama'     => 'Siswa Nonaktif Test',
                'username' => 'siswatestnonaktif',
                'password' => Hash::make('password123'),
                'id_role'  => 3,
                'status'   => 'nonaktif',
                'must_change_password' => false,
            ]
        );
    }

    protected function tearDown(): void
    {
        User::whereIn('email', ['admin_test_nonaktif@englify.com', 'siswa_test_nonaktif@englify.com'])->delete();
        parent::tearDown();
    }

    /**
     * 1. Siswa dengan status nonaktif TIDAK DAPAT login
     */
    public function test_siswa_nonaktif_cannot_login(): void
    {
        $response = $this->post(route('login.proses'), [
            'email'    => 'siswa_test_nonaktif@englify.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Akun Anda sedang dinonaktifkan oleh Super Admin. Silakan hubungi Super Admin untuk mengaktifkan kembali akun Anda.',
        ]);
        $this->assertGuest();
    }

    /**
     * 2. Admin dengan status nonaktif TIDAK DAPAT login
     */
    public function test_admin_nonaktif_cannot_login(): void
    {
        $response = $this->post(route('login.proses'), [
            'email'    => 'admin_test_nonaktif@englify.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'Akun Anda sedang dinonaktifkan oleh Super Admin. Silakan hubungi Super Admin untuk mengaktifkan kembali akun Anda.',
        ]);
        $this->assertGuest();
    }

    /**
     * 3. Jika status diubah kembali menjadi 'aktif', akun BISA login kembali
     */
    public function test_user_can_login_again_after_activated_by_superadmin(): void
    {
        // Superadmin mengaktifkan kembali akun siswa
        $this->siswaNonaktif->status = 'aktif';
        $this->siswaNonaktif->saveQuietly();

        $response = $this->post(route('login.proses'), [
            'email'    => 'siswa_test_nonaktif@englify.com',
            'password' => 'password123',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertAuthenticatedAs($this->siswaNonaktif);
    }

    /**
     * 4. Superadmin yang sudah ganti email & password TIDAK BISA login dengan kredensial lama
     */
    public function test_superadmin_tidak_bisa_login_dengan_email_atau_password_lama(): void
    {
        $superadmin = User::create([
            'nama'                 => 'QA Superadmin Lama',
            'username'             => 'superadmin-qa-' . uniqid(),
            'email'                => 'superadmin_lama_' . uniqid() . '@englify.com',
            'password'             => Hash::make('password_lama_123'),
            'id_role'              => 1,
            'status'               => 'aktif',
            'must_change_password' => false,
        ]);

        $oldEmail = $superadmin->email;
        $username = $superadmin->username;
        $oldPassword = 'password_lama_123';
        $newEmail = 'superadmin_baru_' . uniqid() . '@englify.com';
        $newPassword = 'password_baru_456';

        // Superadmin mengganti email & password ke yang baru
        $superadmin->email = $newEmail;
        $superadmin->password = Hash::make($newPassword);
        $superadmin->save();

        // A. Coba login dengan EMAIL LAMA dan PASSWORD LAMA -> HARUS GAGAL
        $resA = $this->post(route('login.proses'), [
            'email'    => $oldEmail,
            'password' => $oldPassword,
        ]);
        $resA->assertSessionHasErrors('email');
        $this->assertGuest();

        // B. Coba login dengan EMAIL LAMA dan PASSWORD BARU -> HARUS GAGAL
        $resB = $this->post(route('login.proses'), [
            'email'    => $oldEmail,
            'password' => $newPassword,
        ]);
        $resB->assertSessionHasErrors('email');
        $this->assertGuest();

        // C. Coba login dengan USERNAME dan PASSWORD LAMA -> HARUS GAGAL
        $resC = $this->post(route('login.proses'), [
            'email'    => $username,
            'password' => $oldPassword,
        ]);
        $resC->assertSessionHasErrors('email');
        $this->assertGuest();

        // D. Coba login dengan USERNAME dan password default/dev -> HARUS GAGAL
        $resD = $this->post(route('login.proses'), [
            'email'    => $username,
            'password' => 'password123',
        ]);
        $resD->assertSessionHasErrors('email');
        $this->assertGuest();

        // E. Coba login dengan EMAIL BARU dan PASSWORD BARU -> BERHASIL
        $resE = $this->post(route('login.proses'), [
            'email'    => $newEmail,
            'password' => $newPassword,
        ]);
        $resE->assertSessionHasNoErrors();
        $resE->assertRedirect(route('superadmin.dashboard'));
        $this->assertAuthenticatedAs($superadmin);

        // Logout untuk verifikasi via username
        $this->post(route('logout'));
        $this->assertGuest();

        // F. Coba login dengan USERNAME dan PASSWORD BARU -> BERHASIL
        $resF = $this->post(route('login.proses'), [
            'email'    => $username,
            'password' => $newPassword,
        ]);
        $resF->assertSessionHasNoErrors();
        $resF->assertRedirect(route('superadmin.dashboard'));
        $this->assertAuthenticatedAs($superadmin);

        $superadmin->delete();
    }
}
