<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Kategori;
use App\Models\User;
use App\Models\Materi;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Roles
        $roleSuperAdmin = Role::create(['nama_role' => 'Super Admin']);
        $roleAdminDivisi = Role::create(['nama_role' => 'Admin Divisi']);
        $roleSiswa = Role::create(['nama_role' => 'Siswa']);

        // 2. Buat Kategori (Bidang English Club)
        $katSpeaking = Kategori::create(['nama_kategori' => 'Speaking', 'deskripsi' => 'Materi praktik berbicara']);
        $katWriting = Kategori::create(['nama_kategori' => 'Writing', 'deskripsi' => 'Materi tata bahasa dan menulis']);
        $katListening = Kategori::create(['nama_kategori' => 'Listening', 'deskripsi' => 'Materi mendengarkan audio']);
        $katReading = Kategori::create(['nama_kategori' => 'Reading', 'deskripsi' => 'Materi membaca teks']);

        // 3. Buat Users (Password default: 'password123')
        $password = Hash::make('password123');

        // Super Admin
        User::create([
            'id_role' => $roleSuperAdmin->id_role,
            'nama' => 'Super Admin',
            'username' => 'admin',
            'email' => 'admin@englify.com',
            'password' => $password,
        ]);

        // Admin Divisi (Mengelola Speaking)
        $adminSpeaking = User::create([
            'id_role' => $roleAdminDivisi->id_role,
            'id_kategori' => $katSpeaking->id_kategori,
            'nama' => 'Admin Speaking',
            'username' => 'admin_speaking',
            'email' => 'speaking@englify.com',
            'password' => $password,
        ]);

        // Siswa
        User::create([
            'id_role' => $roleSiswa->id_role,
            'nama' => 'Anggia Tresa (Siswa)',
            'username' => 'siswa1',
            'email' => 'siswa@englify.com',
            'password' => $password,
        ]);

        // 4. Buat Dummy Materi (Untuk Testing)
        $materi = Materi::create([
            'id_kategori' => $katSpeaking->id_kategori,
            'id_admin' => $adminSpeaking->id_user, // Menggunakan ID admin yang baru dibuat
            'judul' => 'Introduction & Greetings',
            'bab' => 'Bab 1',
            'urutan' => 1,
            'status' => 'Published',
            'deskripsi' => 'Belajar cara memperkenalkan diri dalam bahasa Inggris.',
            'isi_materi' => '<p>Hello! My name is... How do you do?</p>',
            'audio_url' => null,
            'transcript' => 'Hello! My name is... How do you do?',
        ]);

        // 5. Buat Dummy Quiz untuk Materi di atas
        Quiz::create([
            'id_materi' => $materi->id_materi,
            'pertanyaan' => 'Apa arti dari "How do you do?"',
            'pilihan_a' => 'Apa kabar?',
            'pilihan_b' => 'Siapa namamu?',
            'pilihan_c' => 'Dimana rumahmu?',
            'pilihan_d' => 'Berapa usiamu?',
            'kunci_jawaban' => 'A',
            'poin' => 10,
        ]);
    }
}
