<?php

namespace Tests\Feature;

use App\Models\Bab;
use App\Models\Kategori;
use App\Models\Materi;
use App\Models\HasilQuiz;
use App\Models\Quiz;
use App\Models\User;
use Tests\TestCase;

class CurriculumWithoutSubbabTest extends TestCase
{
    protected User $superadmin;
    protected User $admin;
    protected User $siswa;

    protected function setUp(): void
    {
        parent::setUp();

        $this->cleanupTestData();

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

    protected function tearDown(): void
    {
        $this->cleanupTestData();
        parent::tearDown();
    }

    protected function cleanupTestData(): void
    {
        $testBabs = Bab::where('urutan', 999)->orWhere('judul', 'like', '%Pengujian%')->get();
        foreach ($testBabs as $b) {
            Quiz::where('id_bab', $b->id)->delete();
            Materi::where('id_bab', $b->id)->delete();
            $b->delete();
        }
        Materi::where('judul', 'like', '%Pengujian%')->delete();
    }

    public function test_kategori_has_correct_color_attributes(): void
    {
        $speaking = Kategori::where('nama_kategori', 'Speaking')->first();
        if ($speaking) {
            $this->assertEquals('red', $speaking->color['name']);
            $this->assertStringContainsString('rose', $speaking->color['badge']);
        }

        $writing = Kategori::where('nama_kategori', 'Writing')->first();
        if ($writing) {
            $this->assertEquals('blue', $writing->color['name']);
            $this->assertStringContainsString('blue', $writing->color['badge']);
        }

        $reading = Kategori::where('nama_kategori', 'Reading')->first();
        if ($reading) {
            $this->assertEquals('emerald', $reading->color['name']);
            $this->assertStringContainsString('emerald', $reading->color['badge']);
        }

        $listening = Kategori::where('nama_kategori', 'Listening')->first();
        if ($listening) {
            $this->assertEquals('purple', $listening->color['name']);
            $this->assertStringContainsString('purple', $listening->color['badge']);
        }
    }

    public function test_bab_model_relations_without_subbab(): void
    {
        $kategori = Kategori::first();
        $bab = Bab::create([
            'id_kategori' => $kategori->id_kategori,
            'judul'       => 'Bab Testing Relasi',
            'urutan'      => 1,
            'is_active'   => 1,
        ]);

        $this->assertNotNull($bab);
        $this->assertNotNull($bab->kategori);
        $this->assertIsIterable($bab->materi);
        $this->assertIsIterable($bab->quizzes);

        $bab->delete();
    }

    public function test_api_babs_by_kategori_returns_valid_json(): void
    {
        $kategori = Kategori::first();
        $this->assertNotNull($kategori);

        $bab = Bab::create([
            'id_kategori' => $kategori->id_kategori,
            'judul'       => 'Bab Testing API',
            'urutan'      => 1,
            'is_active'   => 1,
        ]);

        $response = $this->actingAs($this->admin)
            ->getJson("/admin/api/babs-by-kategori/{$kategori->id_kategori}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                '*' => ['id', 'judul', 'urutan']
            ]);

        $bab->delete();
    }

    public function test_admin_materi_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->admin)
            ->get('/admin/materi');

        $response->assertStatus(200);
        $response->assertSee('Kelola Materi');
    }

    public function test_admin_quiz_page_renders_successfully(): void
    {
        $response = $this->actingAs($this->admin)
            ->get('/admin/quiz');

        $response->assertStatus(200);
        $response->assertSee('Kelola Soal Quiz');
    }

    public function test_admin_profil_renders_without_username_and_without_divisi_info(): void
    {
        $admin = User::where('email', 'adminenglish2@gmail.com')->first() ?? $this->admin;

        $response = $this->actingAs($admin)
            ->get('/admin/profil');

        $response->assertStatus(200);
        $response->assertSee('Statistik Kurikulum');
        $response->assertSee('Cakupan Pengelolaan');
        $response->assertSee('Administrator');
        $response->assertDontSee('>Username<');
        $response->assertDontSee('ENG-ADM-');
        $response->assertDontSee('Informasi Divisi');
        $response->assertDontSee('Ditunjuk sebagai admin untuk divisi ini');
    }

    public function test_admin_bab_page_renders_and_crud_works(): void
    {
        // 1. Render halaman Kelola Bab
        $response = $this->actingAs($this->admin)
            ->get('/admin/bab');

        $response->assertStatus(200);
        $response->assertSee('Kelola Bab Kurikulum');

        // 2. Tambah Bab Baru via AJAX
        $kategori = Kategori::first();
        $storeResponse = $this->actingAs($this->admin)
            ->postJson('/admin/bab', [
                'id_kategori' => $kategori->id_kategori,
                'judul'       => 'Bab Testing Otomatis',
                'urutan'      => 99,
            ]);

        $storeResponse->assertStatus(200)
            ->assertJson([
                'success' => true,
            ]);

        $babId = $storeResponse->json('data.id');
        $this->assertDatabaseHas('bab', ['id' => $babId, 'judul' => 'Bab Testing Otomatis']);

        // 3. Update Bab
        $updateResponse = $this->actingAs($this->admin)
            ->putJson("/admin/bab/{$babId}", [
                'id_kategori' => $kategori->id_kategori,
                'judul'       => 'Bab Testing Diedit',
                'urutan'      => 99,
                'is_active'   => 1,
            ]);

        $updateResponse->assertStatus(200);
        $this->assertDatabaseHas('bab', ['id' => $babId, 'judul' => 'Bab Testing Diedit']);

        // 4. Hapus Bab
        $deleteResponse = $this->actingAs($this->admin)
            ->delete("/admin/bab/{$babId}");

        $deleteResponse->assertSessionHas('success');
        $this->assertDatabaseMissing('bab', ['id' => $babId]);
    }

    public function test_siswa_materi_page_renders_with_category_badges(): void
    {
        $response = $this->actingAs($this->siswa)
            ->get('/siswa/materi');

        $response->assertStatus(200);
        $response->assertSee('Semua Kategori');
        $response->assertDontSee('Divisi Speaking');
    }

    public function test_siswa_peta_quiz_renders_properly(): void
    {
        $response = $this->actingAs($this->siswa)
            ->get('/siswa/peta-quiz');

        $response->assertStatus(200);
        $response->assertSee('Peta Quiz');
    }

    public function test_siswa_dashboard_renders_without_subbab(): void
    {
        $response = $this->actingAs($this->siswa)
            ->get('/siswa/dashboard');

        $response->assertStatus(200);
        $response->assertDontSee('Belum ada subbab');
        $response->assertSee('Dashboard');
        $response->assertSee('Halo,');
        $response->assertSee('liveClockCardSiswa');
        $response->assertSee('siswaGreetingTime');
        $response->assertSee('siswaDayProgress');
    }

    public function test_siswa_baca_materi_page_renders_and_has_quiz_link(): void
    {
        $kategori = Kategori::first() ?? Kategori::create(['nama_kategori' => 'Speaking', 'deskripsi' => 'Testing']);
        $bab = null;
        $materi = null;
        $quiz = null;
        $hasil = null;

        try {
            $bab = Bab::create([
                'id_kategori' => $kategori->id_kategori,
                'judul'       => 'Bab Test Baca Materi',
                'urutan'      => 1,
                'is_active'   => 1,
            ]);

            $materi = Materi::create([
                'id_kategori' => $kategori->id_kategori,
                'id_bab'      => $bab->id,
                'bab'         => $bab->judul,
                'id_admin'    => $this->superadmin->id_user,
                'judul'       => 'Materi Test Baca Siswa',
                'isi_materi'  => 'Konten test materi untuk siswa',
                'status'      => 'Published',
                'urutan'      => 1,
            ]);

            $quiz = Quiz::create([
                'id_bab'        => $bab->id,
                'id_materi'     => $materi->id_materi,
                'pertanyaan'    => 'Pertanyaan quiz baca materi test',
                'pilihan_a'     => 'A',
                'pilihan_b'     => 'B',
                'pilihan_c'     => 'C',
                'pilihan_d'     => 'D',
                'kunci_jawaban' => 'a',
                'status'        => 'Aktif',
                'urutan'        => 1,
            ]);

            // Kondisi 1: Siswa baru baca dan belum selesai kuis -> ada tombol "Lanjut ke Quiz"
            $response = $this->actingAs($this->siswa)
                ->get("/siswa/materi/{$materi->id_materi}");

            $response->assertStatus(200);
            $response->assertSee($materi->judul);
            $response->assertSee('Lanjut ke Quiz');

            // Kondisi 2: Siswa sudah selesai kuis (ada di HasilQuiz) -> TIDAK ada tombol "Lanjut ke Quiz", hanya baca & kembali
            $hasil = HasilQuiz::create([
                'id_user'        => $this->siswa->id_user,
                'id_quiz'        => $quiz->id_quiz,
                'skor_diperoleh' => 100,
                'total_soal'     => 1,
                'jawaban_benar'  => 1,
                'jawaban_salah'  => 0,
            ]);

            $responseSetelahKuis = $this->actingAs($this->siswa)
                ->get("/siswa/materi/{$materi->id_materi}");

            $responseSetelahKuis->assertStatus(200);
            $responseSetelahKuis->assertDontSee('Lanjut ke Quiz');
            $responseSetelahKuis->assertSee('Kembali ke Daftar Materi');
            $responseSetelahKuis->assertSee('Hebat! Kamu sudah menyelesaikan materi dan quiz ini');
        } finally {
            if ($hasil) {
                $hasil->delete();
            }
            if ($quiz) {
                $quiz->delete();
            }
            if ($materi) {
                $materi->delete();
            }
            if ($bab) {
                $bab->delete();
            }
        }
    }

    public function test_404_error_page_renders_compactly(): void
    {
        $response = $this->actingAs($this->siswa)
            ->get('/halaman-yang-pasti-tidak-ada-404-test');

        $response->assertStatus(404);
        $response->assertSee('Halaman Tidak Ditemukan');
        $response->assertSee('lg:h-screen');
        $response->assertSee('lg:overflow-hidden');
    }

    public function test_siswa_kerjakan_quiz_page_renders_successfully(): void
    {
        // Temukan quiz yang tidak terkunci (materi pertama dalam babnya atau kuis standalone)
        $unlockedQuiz = Quiz::visibleForSiswa()->whereHas('materi', function ($q) {
            $q->where('urutan', 1);
        })->first();

        if ($unlockedQuiz) {
            \App\Models\HasilQuiz::where('id_user', $this->siswa->id_user)
                ->where('id_quiz', $unlockedQuiz->id_quiz)
                ->delete();

            if ($unlockedQuiz->id_materi) {
                // Siswa masuk dan baca materi terlebih dahulu sesuai alur
                $this->actingAs($this->siswa)->get("/siswa/materi/{$unlockedQuiz->id_materi}");
            }

            $response = $this->actingAs($this->siswa)
                ->get("/siswa/quiz/{$unlockedQuiz->id_quiz}");

            $response->assertStatus(200);
            $response->assertDontSee('ParseError');
        }
    }

    public function test_siswa_tidak_bisa_kerjakan_quiz_jika_belum_baca_materi(): void
    {
        $kategori = Kategori::first();
        $bab = Bab::create([
            'id_kategori' => $kategori->id_kategori,
            'judul'       => 'Bab Pengujian Baca Dahulu',
            'urutan'      => 998,
            'is_active'   => 1,
        ]);

        $materi = Materi::create([
            'id_admin'    => $this->superadmin->id_user,
            'id_kategori' => $kategori->id_kategori,
            'id_bab'      => $bab->id,
            'judul'       => 'Materi Uji Belum Dibaca',
            'bab'         => $bab->judul,
            'urutan'      => 1,
            'status'      => 'Published',
            'isi_materi'  => 'Isi materi uji',
        ]);

        $quiz = Quiz::create([
            'id_materi'     => $materi->id_materi,
            'id_bab'        => $bab->id,
            'pertanyaan'    => 'Soal Uji',
            'pilihan_a'     => 'A',
            'pilihan_b'     => 'B',
            'pilihan_c'     => 'C',
            'pilihan_d'     => 'D',
            'kunci_jawaban' => 'a',
            'poin'          => 10,
            'urutan'        => 1,
            'status'        => 'Aktif',
        ]);

        try {
            // Belum baca materi -> harus redirect ke halaman materi dengan pesan error
            $response = $this->actingAs($this->siswa)->get("/siswa/quiz/{$quiz->id_quiz}");
            $response->assertRedirect(route('siswa.materi.baca', $materi->id_materi));
            $response->assertSessionHas('error');

            // Setelah baca materi -> quiz bisa diakses dengan sukses
            $this->actingAs($this->siswa)->get("/siswa/materi/{$materi->id_materi}");
            $responseAfterRead = $this->actingAs($this->siswa)->get("/siswa/quiz/{$quiz->id_quiz}");
            $responseAfterRead->assertStatus(200);
        } finally {
            \App\Models\HasilQuiz::where('id_quiz', $quiz->id_quiz)->delete();
            \App\Models\ProgressMateri::where('id_user', $this->siswa->id_user)->delete();
            $quiz->delete();
            $materi->delete();
            $bab->delete();
        }
    }

    public function test_sequential_materi_and_quiz_locking_workflow(): void
    {
        $kategori = Kategori::first();
        $this->assertNotNull($kategori);

        $bab = Bab::create([
            'id_kategori' => $kategori->id_kategori,
            'judul'       => 'Bab Pengujian Lock Bertahap',
            'urutan'      => 999,
            'is_active'   => 1,
        ]);

        $materi1 = Materi::create([
            'id_admin'    => $this->superadmin->id_user,
            'id_kategori' => $kategori->id_kategori,
            'id_bab'      => $bab->id,
            'bab'         => $bab->judul,
            'judul'       => 'Materi 1 Pengujian',
            'isi_materi'  => '<p>Konten Materi 1</p>',
            'urutan'      => 1,
            'status'      => 'Published',
        ]);

        $quiz1 = Quiz::create([
            'id_bab'        => $bab->id,
            'id_materi'     => $materi1->id_materi,
            'pertanyaan'    => 'Soal Uji 1?',
            'pilihan_a'     => 'A',
            'pilihan_b'     => 'B',
            'pilihan_c'     => 'C',
            'pilihan_d'     => 'D',
            'kunci_jawaban' => 'a',
            'poin'          => 10,
            'urutan'        => 1,
            'status'        => 'Aktif',
        ]);

        $materi2 = Materi::create([
            'id_admin'    => $this->superadmin->id_user,
            'id_kategori' => $kategori->id_kategori,
            'id_bab'      => $bab->id,
            'bab'         => $bab->judul,
            'judul'       => 'Materi 2 Pengujian',
            'isi_materi'  => '<p>Konten Materi 2</p>',
            'urutan'      => 2,
            'status'      => 'Published',
        ]);

        $quiz2 = Quiz::create([
            'id_bab'        => $bab->id,
            'id_materi'     => $materi2->id_materi,
            'pertanyaan'    => 'Soal Uji 2?',
            'pilihan_a'     => 'A',
            'pilihan_b'     => 'B',
            'pilihan_c'     => 'C',
            'pilihan_d'     => 'D',
            'kunci_jawaban' => 'b',
            'poin'          => 10,
            'urutan'        => 1,
            'status'        => 'Aktif',
        ]);

        try {
            // 1. Materi 1 dan Quiz 1 HARUS terbuka secara default
            $resMateri1 = $this->actingAs($this->siswa)->get("/siswa/materi/{$materi1->id_materi}");
            $resMateri1->assertStatus(200);

            $resQuiz1 = $this->actingAs($this->siswa)->get("/siswa/quiz/{$quiz1->id_quiz}");
            $resQuiz1->assertStatus(200);

            // 2. Materi 2 dan Quiz 2 HARUS TERKUNCI karena Quiz 1 belum selesai
            $resMateri2 = $this->actingAs($this->siswa)->get("/siswa/materi/{$materi2->id_materi}");
            $resMateri2->assertRedirect(route('siswa.materi'));
            $resMateri2->assertSessionHas('error');

            $resQuiz2 = $this->actingAs($this->siswa)->get("/siswa/quiz/{$quiz2->id_quiz}");
            $resQuiz2->assertRedirect(route('siswa.materi'));
            $resQuiz2->assertSessionHas('error');

            // 3. Siswa menyelesaikan Quiz 1
            \App\Models\HasilQuiz::create([
                'id_user'        => $this->siswa->id_user,
                'id_quiz'        => $quiz1->id_quiz,
                'skor_diperoleh' => 100,
            ]);

            // 4. Sekarang Materi 2 dan Quiz 2 HARUS TERBUKA
            $resMateri2Unlocked = $this->actingAs($this->siswa)->get("/siswa/materi/{$materi2->id_materi}");
            $resMateri2Unlocked->assertStatus(200);

            $resQuiz2Unlocked = $this->actingAs($this->siswa)->get("/siswa/quiz/{$quiz2->id_quiz}");
            $resQuiz2Unlocked->assertStatus(200);

        } finally {
            // Cleanup data testing
            \App\Models\HasilQuiz::where('id_quiz', $quiz1->id_quiz)->delete();
            \App\Models\HasilQuiz::where('id_quiz', $quiz2->id_quiz)->delete();
            \App\Models\ProgressMateri::where('id_user', $this->siswa->id_user)->delete();
            $quiz1->delete();
            $quiz2->delete();
            $materi1->delete();
            $materi2->delete();
            $bab->delete();
        }
    }

    public function test_siswa_progres_page_renders_with_empty_state(): void
    {
        \App\Models\ProgressMateri::where('id_user', $this->siswa->id_user)->delete();
        \App\Models\HasilQuiz::where('id_user', $this->siswa->id_user)->delete();

        $response = $this->actingAs($this->siswa)
            ->get('/siswa/progres');

        $response->assertStatus(200);
        $response->assertSee('Aktivitas Minggu Ini');
        $response->assertSee('Belum Ada Aktivitas Minggu Ini');
        $response->assertSee('Mulai Belajar Materi');
        $response->assertSee('Progress Per Kategori');
        $response->assertSee('0%');
        // Pastikan tidak ada data dummy hardcode lama (75% / 60% / 40%)
        $response->assertDontSee('75%');
        $response->assertDontSee('60%');
        $response->assertSee('Book Worm');
        $response->assertSee('🔒');
    }

    public function test_siswa_can_delete_and_clear_reminders(): void
    {
        $pesan = \App\Models\PesanAdmin::create([
            'id_user'  => $this->siswa->id_user,
            'id_admin' => $this->superadmin->id_user,
            'pesan'    => 'Pengingat uji coba',
            'is_read'  => false,
        ]);

        // Delete single reminder
        $resDelete = $this->actingAs($this->siswa)
            ->delete(route('siswa.reminder.destroy', $pesan->id));
        $resDelete->assertStatus(302);
        $this->assertDatabaseMissing('pesan_admin', ['id' => $pesan->id]);

        // Create 2 reminders and clear all
        \App\Models\PesanAdmin::create([
            'id_user'  => $this->siswa->id_user,
            'id_admin' => $this->superadmin->id_user,
            'pesan'    => 'Pengingat 1',
            'is_read'  => false,
        ]);
        \App\Models\PesanAdmin::create([
            'id_user'  => $this->siswa->id_user,
            'id_admin' => $this->superadmin->id_user,
            'pesan'    => 'Pengingat 2',
            'is_read'  => false,
        ]);

        $resClear = $this->actingAs($this->siswa)
            ->delete(route('siswa.reminder.clearAll'));
        $resClear->assertStatus(302);
        $this->assertDatabaseMissing('pesan_admin', ['id_user' => $this->siswa->id_user]);
    }

    public function test_siswa_tidak_bisa_mengulang_quiz_yang_sudah_selesai(): void
    {
        $kategori = Kategori::first();
        $bab = Bab::create([
            'id_kategori' => $kategori->id_kategori,
            'judul'       => 'Bab Uji Anti Retake',
            'urutan'      => 999,
            'is_active'   => true,
        ]);

        $materi = Materi::create([
            'id_kategori' => $kategori->id_kategori,
            'id_bab'      => $bab->id,
            'bab'         => $bab->judul,
            'id_admin'    => $this->superadmin->id_user,
            'judul'       => 'Materi Uji Anti Retake',
            'isi_materi'  => 'Konten test anti retake',
            'status'      => 'Published',
            'urutan'      => 1,
        ]);

        $quiz = Quiz::create([
            'id_bab'         => $bab->id,
            'id_materi'      => $materi->id_materi,
            'pertanyaan'     => 'Apa ibu kota Indonesia?',
            'pilihan_a'      => 'Jakarta',
            'pilihan_b'      => 'Bandung',
            'pilihan_c'      => 'Surabaya',
            'pilihan_d'      => 'Medan',
            'kunci_jawaban'  => 'A',
            'poin'           => 10,
            'status'         => 'Aktif',
            'urutan'         => 1,
        ]);

        try {
            // Siswa baca materi
            $this->actingAs($this->siswa)->get("/siswa/materi/{$materi->id_materi}");

            // Buat hasil kuis (siswa sudah menyelesaikan kuis)
            \App\Models\HasilQuiz::create([
                'id_user'        => $this->siswa->id_user,
                'id_quiz'        => $quiz->id_quiz,
                'skor_diperoleh' => 100,
            ]);

            // Coba buka halaman kerjakan kuis -> Harus diredirect ke halaman hasil kuis
            $response = $this->actingAs($this->siswa)
                ->get("/siswa/quiz/{$quiz->id_quiz}");

            $response->assertRedirect(route('siswa.quiz.hasil', $quiz->id_quiz));
            $response->assertSessionHas('info');

            // Coba submit kuis lagi -> Harus diredirect ke halaman hasil kuis
            $postResponse = $this->actingAs($this->siswa)
                ->post("/siswa/quiz/{$quiz->id_quiz}/submit", [
                    'jawaban_' . $quiz->id_quiz => 'A',
                ]);

            $postResponse->assertRedirect(route('siswa.quiz.hasil', $quiz->id_quiz));
            $postResponse->assertSessionHas('info');
        } finally {
            \App\Models\HasilQuiz::where('id_quiz', $quiz->id_quiz)->delete();
            \App\Models\ProgressMateri::where('id_user', $this->siswa->id_user)->delete();
            $quiz->delete();
            $materi->delete();
            $bab->delete();
        }
    }
}

