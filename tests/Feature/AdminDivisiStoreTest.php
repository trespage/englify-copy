<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AdminDivisiStoreTest extends TestCase
{
    public function test_superadmin_dapat_menambah_admin_divisi_dan_muncul_di_daftar(): void
    {
        $superadmin = User::where('email', 'superadmin@englify.com')->first()
            ?? User::where('id_role', 1)->first();
        $this->assertNotNull($superadmin, 'Butuh akun superadmin (id_role=1)');

        $email = 'qatest-admin-divisi@example.com';
        User::where('email', $email)->delete();

        // 1. Simpan via route yang dipakai modal (sebelumnya tidak pernah terkirim karena JS dummy)
        $res = $this->actingAs($superadmin)->post(route('superadmin.adminDivisi.store'), [
            'nama' => 'QA Admin Divisi',
            'email' => $email,
            'password' => 'password123',
            'status' => 'aktif',
        ]);
        $res->assertRedirect(route('superadmin.adminDivisi'));

        // 2. Tersimpan di database dengan role admin divisi
        $this->assertDatabaseHas('users', ['email' => $email, 'id_role' => 2]);

        // 3. Muncul di halaman daftar admin divisi (tanpa sisa JS dummy lama)
        $list = $this->actingAs($superadmin)->get(route('superadmin.adminDivisi'));
        $list->assertOk();
        $list->assertSee($email);
        $list->assertDontSee('Implementasi AJAX');

        // 3b. Email duplikat ditolak dengan pesan error (sekarang tampil di halaman)
        $this->actingAs($superadmin)->post(route('superadmin.adminDivisi.store'), [
            'nama' => 'Duplikat',
            'email' => $email,
            'password' => 'password123',
            'status' => 'aktif',
        ])->assertSessionHasErrors('email');

        // 4. Update + hapus juga lewat route yang sama dipakai modal
        $created = User::where('email', $email)->first();
        $this->actingAs($superadmin)->put(
            route('superadmin.adminDivisi.update', ['id' => $created->id_user]),
            ['nama' => 'QA Admin Divisi Updated', 'email' => $email, 'status' => 'nonaktif']
        )->assertRedirect(route('superadmin.adminDivisi'));
        $this->assertDatabaseHas('users', ['email' => $email, 'status' => 'nonaktif']);

        $this->actingAs($superadmin)->delete(
            route('superadmin.adminDivisi.destroy', ['id' => $created->id_user])
        )->assertRedirect(route('superadmin.adminDivisi'));
        $this->assertDatabaseMissing('users', ['email' => $email]);
    }
}
