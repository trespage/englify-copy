<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // Buat akun Super Admin (id_role 1 = Super Admin)
        User::updateOrCreate(
            ['email' => 'superadmin@englify.com'],
            [
                'id_role' => 1,
                'nama' => 'Super Admin',
                'username' => 'superadmin',
                'password' => Hash::make('password123'),
                'must_change_password' => false,
            ]
        );
    }
}
