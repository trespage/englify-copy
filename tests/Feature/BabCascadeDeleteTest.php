<?php

namespace Tests\Feature;

use App\Models\Bab;
use App\Models\Kategori;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\HasilQuiz;
use App\Models\JawabanUser;
use App\Models\ProgressMateri;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class BabCascadeDeleteTest extends TestCase
{
    /** @var User[] */
    private array $createdUsers = [];

    protected function tearDown(): void
    {
        foreach ($this->createdUsers as $user) {
            User::where('id_user', $user->id_user)->delete();
        }
        $this->createdUsers = [];

        parent::tearDown();
    }

    public function test_deleting_bab_deletes_associated_materi_and_quizzes(): void
    {
        // 1. Buat admin
        $admin = User::create([
            'nama'                 => 'Admin Bab QA',
            'username'             => 'admin-bab-' . uniqid(),
            'email'                => 'admin-bab-' . uniqid() . '@example.com',
            'password'             => Hash::make('password123'),
            'id_role'              => 2,
            'status'               => 'aktif',
            'must_change_password' => false,
        ]);
        $this->createdUsers[] = $admin;

        // 2. Ambil / buat kategori
        $kategori = Kategori::first() ?? Kategori::create([
            'nama_kategori' => 'Speaking QA',
            'deskripsi'     => 'Testing kategori',
        ]);

        // 3. Buat Bab
        $bab = Bab::create([
            'id_kategori' => $kategori->id_kategori,
            'judul'       => 'Bab Uji Hapus ' . uniqid(),
            'urutan'      => 999,
            'is_active'   => true,
        ]);

        // 4. Buat Materi di Bab ini
        $materi = Materi::create([
            'id_kategori' => $kategori->id_kategori,
            'id_bab'      => $bab->id,
            'id_admin'    => $admin->id_user,
            'judul'       => 'Materi Uji ' . uniqid(),
            'bab'         => $bab->judul,
            'urutan'      => 1,
            'isi_materi'  => 'Konten materi uji',
            'status'      => 'Published',
        ]);

        // 5. Buat Quiz di Bab & Materi ini
        $quiz1 = Quiz::create([
            'id_materi'     => $materi->id_materi,
            'id_bab'        => $bab->id,
            'pertanyaan'    => 'Pertanyaan 1',
            'pilihan_a'     => 'A',
            'pilihan_b'     => 'B',
            'pilihan_c'     => 'C',
            'pilihan_d'     => 'D',
            'kunci_jawaban' => 'A',
            'poin'          => 10,
        ]);

        // 6. Buat Quiz kedua di Materi ini
        $quiz2 = Quiz::create([
            'id_materi'     => $materi->id_materi,
            'id_bab'        => $bab->id,
            'pertanyaan'    => 'Pertanyaan 2',
            'pilihan_a'     => 'A',
            'pilihan_b'     => 'B',
            'pilihan_c'     => 'C',
            'pilihan_d'     => 'D',
            'kunci_jawaban' => 'B',
            'poin'          => 10,
        ]);

        // 7. Simulasikan progress materi & hasil quiz
        $progress = ProgressMateri::create([
            'id_user'   => $admin->id_user,
            'id_materi' => $materi->id_materi,
            'status'    => 'Started',
        ]);

        $hasil = HasilQuiz::create([
            'id_user'        => $admin->id_user,
            'id_quiz'        => $quiz1->id_quiz,
            'skor_diperoleh' => 10,
        ]);

        $jawaban = JawabanUser::create([
            'id_hasil'     => $hasil->id_hasil,
            'id_quiz'      => $quiz1->id_quiz,
            'jawaban_user' => 'A',
            'benar'        => true,
        ]);

        // 8. Lakukan request DELETE Bab
        $response = $this->actingAs($admin)->delete(route('admin.bab.destroy', $bab->id));
        $response->assertSessionHas('success');

        // 9. Pastikan Bab, Materi, Quiz, dan relasi anaknya sudah terhapus
        $this->assertDatabaseMissing('bab', ['id' => $bab->id]);
        $this->assertDatabaseMissing('materi', ['id_materi' => $materi->id_materi]);
        $this->assertDatabaseMissing('quiz', ['id_quiz' => $quiz1->id_quiz]);
        $this->assertDatabaseMissing('quiz', ['id_quiz' => $quiz2->id_quiz]);
        $this->assertDatabaseMissing('progress_materi', ['id_progress' => $progress->id_progress]);
        $this->assertDatabaseMissing('hasil_quiz', ['id_hasil' => $hasil->id_hasil]);
        $this->assertDatabaseMissing('jawaban_user', ['id_jawaban' => $jawaban->id_jawaban]);
    }
}
