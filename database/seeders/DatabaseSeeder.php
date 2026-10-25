<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================================
        // 0. ROLES (Super Admin, Admin, Siswa)
        // ==========================================================
        DB::table('roles')->updateOrInsert(
            ['id_role' => 1],
            ['nama_role' => 'Super Admin', 'updated_at' => now(), 'created_at' => now()]
        );
        DB::table('roles')->updateOrInsert(
            ['id_role' => 2],
            ['nama_role' => 'Admin', 'updated_at' => now(), 'created_at' => now()]
        );
        DB::table('roles')->updateOrInsert(
            ['id_role' => 3],
            ['nama_role' => 'Siswa', 'updated_at' => now(), 'created_at' => now()]
        );

        // ==========================================================
        // 1. KATEGORI UTAMA (idempotent)
        // ==========================================================
        $daftarKategori = [
            ['nama_kategori' => 'Speaking',  'deskripsi' => 'Materi praktik berbicara'],
            ['nama_kategori' => 'Writing',   'deskripsi' => 'Materi tata bahasa dan menulis'],
            ['nama_kategori' => 'Listening', 'deskripsi' => 'Materi mendengarkan audio'],
            ['nama_kategori' => 'Reading',   'deskripsi' => 'Materi membaca teks'],
        ];

        foreach ($daftarKategori as $kategori) {
            Kategori::updateOrCreate(
                ['nama_kategori' => $kategori['nama_kategori']],
                ['deskripsi' => $kategori['deskripsi']]
            );
        }

        // ==========================================================
        // 2. PASTIKAN SETIAP MATERI TERHUBUNG KE BAB
        // ==========================================================
        $unlinked = \App\Models\Materi::whereNull('id_bab')->get();
        foreach ($unlinked as $u) {
            $babJudul = trim($u->bab) ?: 'Bab 1: Pengenalan';
            $bab = \App\Models\Bab::firstOrCreate(
                ['id_kategori' => $u->id_kategori, 'judul' => $babJudul],
                ['urutan' => 1, 'is_active' => true]
            );
            $u->id_bab = $bab->id;
            $u->bab = $bab->judul;
            $u->saveQuietly();
        }

        // ==========================================================
        // 3. PASTIKAN AKUN UTAMA TETAP ADA (Super Admin, Admin Divisi, Siswa)
        // ==========================================================
        $katSpeaking = Kategori::where('nama_kategori', 'Speaking')->first();

        // 3.1 Super Admin
        User::updateOrCreate(
            ['email' => 'superadmin@englify.com'],
            [
                'nama'                 => 'Super Admin',
                'username'             => 'superadmin',
                'password'             => Hash::make('password123'),
                'id_role'              => 1,
                'status'               => 'aktif',
                'must_change_password' => 0,
            ]
        );

        User::updateOrCreate(
            ['email' => 'admin@englify.com'],
            [
                'nama'                 => 'Administrator',
                'username'             => 'admin',
                'password'             => Hash::make('password123'),
                'id_role'              => 1,
                'status'               => 'aktif',
                'must_change_password' => 0,
            ]
        );

        // 3.2 Admin Divisi
        User::updateOrCreate(
            ['email' => 'adminenglish@englify.com'],
            [
                'nama'                 => 'Admin English',
                'username'             => 'adminenglish',
                'password'             => Hash::make('password123'),
                'id_role'              => 2,
                'id_kategori'          => $katSpeaking?->id_kategori,
                'status'               => 'aktif',
                'must_change_password' => 0,
            ]
        );

        User::updateOrCreate(
            ['email' => 'nuraprilia@englify.com'],
            [
                'nama'                 => 'Nur Aprilia',
                'username'             => 'nuraprilia',
                'password'             => Hash::make('password123'),
                'id_role'              => 2,
                'id_kategori'          => $katSpeaking?->id_kategori,
                'status'               => 'aktif',
                'must_change_password' => 0,
            ]
        );

        User::updateOrCreate(
            ['email' => 'speaking@englify.com'],
            [
                'nama'                 => 'Admin Speaking',
                'username'             => 'speaking',
                'password'             => Hash::make('password123'),
                'id_role'              => 2,
                'id_kategori'          => $katSpeaking?->id_kategori,
                'status'               => 'aktif',
                'must_change_password' => 0,
            ]
        );

        // 3.3 Siswa
        User::updateOrCreate(
            ['email' => 'siswa@englify.com'],
            [
                'nama'                 => 'Siswa Englify',
                'username'             => 'siswa',
                'password'             => Hash::make('password123'),
                'id_role'              => 3,
                'status'               => 'aktif',
                'must_change_password' => 0,
            ]
        );

        // ==========================================================
        // 4. SEED SAMPLE BAB, MATERI & QUIZ JIKA KOSONG
        // ==========================================================
        $adminUser = User::where('id_role', 2)->first() ?? User::where('id_role', 1)->first();
        if ($adminUser && \App\Models\Materi::count() === 0) {
            $kategoriList = Kategori::all();
            foreach ($kategoriList as $kat) {
                $bab = \App\Models\Bab::firstOrCreate(
                    ['id_kategori' => $kat->id_kategori, 'judul' => 'Dasar & Pengenalan ' . $kat->nama_kategori],
                    ['urutan' => 1, 'durasi_menit' => 15, 'is_active' => true]
                );

                $materi = \App\Models\Materi::create([
                    'id_kategori' => $kat->id_kategori,
                    'id_admin'    => $adminUser->id_user,
                    'id_bab'      => $bab->id,
                    'bab'         => '1',
                    'judul'       => 'Pengenalan ' . $kat->nama_kategori . ' Bagian 1',
                    'urutan'      => 1,
                    'status'      => 'Published',
                    'deskripsi'   => 'Konsep fundamental pembelajaran ' . $kat->nama_kategori,
                    'isi_materi'  => 'Pelajari materi dasar ini dengan seksama sebelum mengerjakan latihan dan quiz.',
                ]);

                \App\Models\Quiz::create([
                    'id_materi'     => $materi->id_materi,
                    'id_bab'        => $bab->id,
                    'pertanyaan'    => 'Pilihlah ungkapan yang paling tepat untuk menyapa dalam bahasa Inggris!',
                    'pilihan_a'     => 'Good Morning',
                    'pilihan_b'     => 'Good Bye',
                    'pilihan_c'     => 'Good Night',
                    'pilihan_d'     => 'See You',
                    'kunci_jawaban' => 'A',
                    'poin'          => 50,
                    'status'        => 'Aktif',
                    'urutan'        => 1,
                ]);

                \App\Models\Quiz::create([
                    'id_materi'     => $materi->id_materi,
                    'id_bab'        => $bab->id,
                    'pertanyaan'    => 'Apa arti dari kata "Welcome"?',
                    'pilihan_a'     => 'Selamat Jalan',
                    'pilihan_b'     => 'Selamat Datang',
                    'pilihan_c'     => 'Terima Kasih',
                    'pilihan_d'     => 'Sama-sama',
                    'kunci_jawaban' => 'B',
                    'poin'          => 50,
                    'status'        => 'Aktif',
                    'urutan'        => 2,
                ]);
            }
        }

        $this->command->info('Seeder selesai: Kategori, akun, dan kurikulum awal telah siap.');
    }
}
