<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Bab;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\ProgressMateri;
use App\Models\HasilQuiz;
use App\Models\JawabanUser;

class SiswaReviewAndSidebarTest extends TestCase
{
    protected ?User $admin = null;
    protected ?User $siswa = null;
    protected ?Kategori $kategori = null;
    protected ?Bab $bab = null;
    protected ?Materi $materi = null;
    protected ?Quiz $quiz = null;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cleanupTestData();

        $this->admin = User::where('id_role', 2)->first() ?? User::where('id_role', 1)->first();

        $this->siswa = User::where('id_role', 3)->where('must_change_password', 0)->first();
        if (!$this->siswa) {
            $this->siswa = User::where('id_role', 3)->first();
            if ($this->siswa) {
                $this->siswa->must_change_password = 0;
                $this->siswa->status = 'aktif';
                $this->siswa->saveQuietly();
            }
        }

        $this->kategori = Kategori::first();

        $this->bab = Bab::create([
            'id_kategori' => $this->kategori->id_kategori,
            'judul'       => 'Bab Uji Review Satu Kali',
            'urutan'      => 987,
            'is_active'   => true,
            'durasi_menit'=> 15,
        ]);

        $this->materi = Materi::create([
            'id_admin'     => $this->admin->id_user,
            'id_kategori'  => $this->kategori->id_kategori,
            'id_bab'       => $this->bab->id,
            'bab'          => $this->bab->judul,
            'judul'        => 'Materi Uji Review Kuis Sekali',
            'isi_materi'   => 'Konten pembelajaran materi uji review',
            'status'       => 'Published',
            'durasi_menit' => 15,
            'urutan'       => 1,
        ]);

        $this->quiz = Quiz::create([
            'id_bab'        => $this->bab->id,
            'id_materi'     => $this->materi->id_materi,
            'pertanyaan'    => 'Soal Rahasia: What is the past tense of "Go"?',
            'pilihan_a'     => 'Went',
            'pilihan_b'     => 'Gone',
            'pilihan_c'     => 'Goes',
            'pilihan_d'     => 'Going',
            'kunci_jawaban' => 'A',
            'poin'          => 100,
            'status'        => 'Aktif',
            'urutan'        => 1,
        ]);

        // Tandai siswa sudah membaca materi
        ProgressMateri::firstOrCreate(
            ['id_user' => $this->siswa->id_user, 'id_materi' => $this->materi->id_materi],
            ['status' => 'Completed']
        );
    }

    protected function tearDown(): void
    {
        $this->cleanupTestData();
        parent::tearDown();
    }

    protected function cleanupTestData(): void
    {
        $babs = Bab::where('judul', 'like', 'Bab Uji Review Satu Kali%')->get();
        foreach ($babs as $b) {
            $quizIds = Quiz::where('id_bab', $b->id)->pluck('id_quiz')->all();
            if (!empty($quizIds)) {
                $hasilIds = HasilQuiz::whereIn('id_quiz', $quizIds)->pluck('id_hasil')->all();
                JawabanUser::whereIn('id_hasil', $hasilIds)->delete();
                HasilQuiz::whereIn('id_quiz', $quizIds)->delete();
                Quiz::whereIn('id_quiz', $quizIds)->delete();
            }
            Materi::where('id_bab', $b->id)->delete();
            $b->delete();
        }
    }

    /**
     * Revisi 2: Typo Sidebar Siswa diperbaiki dari "Progres" menjadi "Progress"
     */
    public function test_sidebar_displays_progress_belajar_without_typo(): void
    {
        $response = $this->actingAs($this->siswa)->get('/siswa/dashboard');

        $response->assertStatus(200);
        // Memastikan penulisan "Progress Belajar" ada di tampilan
        $response->assertSee('Progress Belajar');
        // Memastikan tidak ada penulisan "Progres Belajar" maupun label nav ">Progres<"
        $response->assertDontSee('Progres Belajar');
        $response->assertDontSee('>Progres<', false);

        // Memastikan label navigasi mobile menggunakan "Reminder", bukan "Pesan"
        $response->assertSee('Reminder');
        $response->assertDontSee('>Pesan<', false);
    }

    /**
     * Revisi 1: Review Jawaban & Pembahasan ditampilkan 1 kali tepat saat kuis selesai disubmit.
     */
    public function test_quiz_review_and_discussion_is_displayed_immediately_after_submit(): void
    {
        // Siswa submit kuis
        $submitResponse = $this->actingAs($this->siswa)->post("/siswa/quiz/{$this->quiz->id_quiz}/submit", [
            'jawaban_' . $this->quiz->id_quiz => 'A',
        ]);

        $submitResponse->assertRedirect(route('siswa.quiz.hasil', $this->quiz->id_quiz));
        $submitResponse->assertSessionHas('can_review_quiz', true);

        // Siswa diarahkan ke halaman hasil setelah submit
        $hasilResponse = $this->actingAs($this->siswa)
            ->withSession(['can_review_quiz' => true, 'show_celebration' => true])
            ->get(route('siswa.quiz.hasil', $this->quiz->id_quiz));

        $hasilResponse->assertStatus(200);
        // Tepat setelah submit, pembahasan dan review jawaban dapat dilihat
        $hasilResponse->assertSee('Pembahasan & Review Jawaban');
        $hasilResponse->assertSee('Soal Rahasia: What is the past tense of "Go"?');
        $hasilResponse->assertSee('Jawaban Kamu (Benar) ✓');
        $hasilResponse->assertSee('Lihat Pembahasan');
    }

    /**
     * Revisi 1: Ketika melihat kembali riwayat hasil kuis, rincian soal & kunci jawaban TIDAK ditampilkan kembali.
     */
    public function test_revisiting_quiz_result_page_hides_questions_and_answer_keys(): void
    {
        // Buat hasil kuis yang sudah pernah dikerjakan sebelumnya
        $hasil = HasilQuiz::create([
            'id_user'        => $this->siswa->id_user,
            'id_quiz'        => $this->quiz->id_quiz,
            'skor_diperoleh' => 100,
        ]);

        JawabanUser::create([
            'id_hasil'      => $hasil->id_hasil,
            'id_quiz'       => $this->quiz->id_quiz,
            'jawaban_user'  => 'A',
            'benar'         => true,
        ]);

        // Siswa membuka kembali halaman hasil quiz (tanpa session flash baru submit)
        $response = $this->actingAs($this->siswa)->get(route('siswa.quiz.hasil', $this->quiz->id_quiz));

        $response->assertStatus(200);

        // Hanya menampilkan ringkasan skor, akurasi, dan status kelulusan
        $response->assertSee('Total Skor');
        $response->assertSee('100');
        $response->assertSee('Akurasi');
        $response->assertSee('Selesai Pada');
        $response->assertSee('Sudah Diselesaikan');
        $response->assertSee('Lulus Kompetensi');

        // Pastikan TIDAK ADA daftar soal, pembahasan, maupun kunci jawaban/review
        $response->assertDontSee('Pembahasan & Review Jawaban');
        $response->assertDontSee('Soal Rahasia: What is the past tense of "Go"?');
        $response->assertDontSee('Kunci Jawaban ✓');
        $response->assertDontSee('Lihat Pembahasan');
        $response->assertDontSee('Pembahasan & Kunci Jawaban Dilindungi');
    }
}
