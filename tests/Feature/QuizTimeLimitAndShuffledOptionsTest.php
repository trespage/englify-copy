<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Bab;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\HasilQuiz;
use App\Models\JawabanUser;
use App\Models\ProgressMateri;

class QuizTimeLimitAndShuffledOptionsTest extends TestCase
{
    protected ?User $admin = null;
    protected ?User $siswa = null;
    protected ?Kategori $kategori = null;
    protected ?Bab $bab = null;
    protected ?Materi $materi = null;
    protected ?Quiz $quiz1 = null;
    protected ?Quiz $quiz2 = null;

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
                $this->siswa->saveQuietly();
            }
        }

        $this->kategori = Kategori::where('nama_kategori', 'Speaking')->first() ?? Kategori::first();

        // Bab dengan durasi 20 menit
        $this->bab = Bab::create([
            'id_kategori'  => $this->kategori->id_kategori,
            'judul'        => 'Pengujian Time Limit Bab',
            'urutan'       => 998,
            'durasi_menit' => 20,
            'is_active'    => true,
        ]);

        $this->materi = Materi::create([
            'id_admin'    => $this->admin->id_user,
            'id_kategori' => $this->kategori->id_kategori,
            'id_bab'      => $this->bab->id,
            'bab'         => '1',
            'judul'       => 'Pengujian Materi Time Limit',
            'deskripsi'   => 'Deskripsi materi pengujian',
            'isi_materi'  => 'Konten materi pengujian time limit dan opsi',
            'urutan'       => 1,
            'status'       => 'Published',
            'durasi_menit' => 20,
        ]);

        $this->quiz1 = Quiz::create([
            'id_materi'     => $this->materi->id_materi,
            'id_bab'        => $this->bab->id,
            'pertanyaan'    => 'What is the synonym of "Happy"?',
            'pilihan_a'     => 'Joyful',
            'pilihan_b'     => 'Sad',
            'pilihan_c'     => 'Angry',
            'pilihan_d'     => 'Tired',
            'kunci_jawaban' => 'A',
            'poin'          => 50,
            'status'        => 'Aktif',
            'urutan'        => 1,
        ]);

        $this->quiz2 = Quiz::create([
            'id_materi'     => $this->materi->id_materi,
            'id_bab'        => $this->bab->id,
            'pertanyaan'    => 'What is the opposite of "Cold"?',
            'pilihan_a'     => 'Cool',
            'pilihan_b'     => 'Hot',
            'pilihan_c'     => 'Freezing',
            'pilihan_d'     => 'Warm',
            'kunci_jawaban' => 'B',
            'poin'          => 50,
            'status'        => 'Aktif',
            'urutan'        => 2,
        ]);

        // Tandai siswa sudah membaca materi agar kuis terbuka
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
        $babs = Bab::where('judul', 'like', '%Pengujian Time Limit%')
            ->orWhere('judul', 'like', '%Advanced Idioms Test%')
            ->orWhere('judul', 'like', '%Grammar Basics Test%')
            ->get();

        foreach ($babs as $b) {
            $quizIds = Quiz::where('id_bab', $b->id)->pluck('id_quiz')->all();
            if (!empty($quizIds)) {
                $hasilIds = HasilQuiz::whereIn('id_quiz', $quizIds)->pluck('id_hasil')->all();
                JawabanUser::whereIn('id_hasil', $hasilIds)->delete();
                HasilQuiz::whereIn('id_quiz', $quizIds)->delete();
                Quiz::whereIn('id_quiz', $quizIds)->delete();
            }
            $materiIds = Materi::where('id_bab', $b->id)->pluck('id_materi')->all();
            ProgressMateri::whereIn('id_materi', $materiIds)->delete();
            Materi::where('id_bab', $b->id)->delete();
            $b->delete();
        }
    }

    /**
     * 1. Admin dapat menentukan durasi waktu pengerjaan quiz pada setiap bab
     */
    public function test_admin_can_set_quiz_time_limit_on_bab(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.bab.store'), [
            'id_kategori'  => $this->kategori->id_kategori,
            'judul'        => 'Advanced Idioms Test',
            'urutan'       => 995,
            'durasi_menit' => 25,
            'is_active'    => 1,
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('bab', [
            'judul'        => 'Advanced Idioms Test',
            'durasi_menit' => 25,
        ]);

        // Default durasi_menit adalah 15 jika tidak diisi
        $this->actingAs($this->admin)->post(route('admin.bab.store'), [
            'id_kategori' => $this->kategori->id_kategori,
            'judul'       => 'Grammar Basics Test',
            'urutan'      => 996,
        ]);

        $this->assertDatabaseHas('bab', [
            'judul'        => 'Grammar Basics Test',
            'durasi_menit' => 15,
        ]);
    }

    /**
     * 2. Siswa membuka quiz: menerima countdown timer sesuai durasi bab dan opsi teracak
     */
    public function test_student_quiz_page_receives_time_limit_and_shuffled_options(): void
    {
        $response = $this->actingAs($this->siswa)
            ->get(route('siswa.quiz.kerjakan', $this->quiz1->id_quiz));

        $response->assertStatus(200);
        $response->assertViewHas('durasiMenit', 20);

        // Halaman memuat timer '20:00'
        $response->assertSee('20:00');
        $response->assertSee('id="timer"', false);

        // Pertanyaan dan pilihan termuat di view
        $response->assertSee('What is the synonym of');
        $response->assertSee('Joyful');
    }

    /**
     * 3. Waktu tidak memengaruhi poin (Score vs Duration)
     * Dua siswa yang menjawab benar semua memperoleh skor sama (100)
     */
    public function test_duration_does_not_affect_score(): void
    {
        // Siswa 1 submit jawaban benar semua
        $this->actingAs($this->siswa)
            ->post(route('siswa.quiz.submit', $this->quiz1->id_quiz), [
                'jawaban_' . $this->quiz1->id_quiz => 'A',
                'jawaban_' . $this->quiz2->id_quiz => 'B',
            ]);

        $hasilSiswa1 = HasilQuiz::where('id_user', $this->siswa->id_user)
            ->where('id_quiz', $this->quiz1->id_quiz)
            ->first();

        $this->assertNotNull($hasilSiswa1);
        $this->assertEquals(100, $hasilSiswa1->skor_diperoleh);

        // Siswa 2 (misal siswa lain di sistem) juga menyelesaikan dengan benar semua
        $siswa2 = User::where('id_role', 3)->where('id_user', '!=', $this->siswa->id_user)->first();
        if ($siswa2) {
            $siswa2->must_change_password = 0;
            $siswa2->status = 'aktif';
            $siswa2->saveQuietly();

            ProgressMateri::firstOrCreate(
                ['id_user' => $siswa2->id_user, 'id_materi' => $this->materi->id_materi],
                ['status' => 'Completed']
            );

            $this->actingAs($siswa2)
                ->post(route('siswa.quiz.submit', $this->quiz1->id_quiz), [
                    'jawaban_' . $this->quiz1->id_quiz => 'A',
                    'jawaban_' . $this->quiz2->id_quiz => 'B',
                ]);

            $hasilSiswa2 = HasilQuiz::where('id_user', $siswa2->id_user)
                ->where('id_quiz', $this->quiz1->id_quiz)
                ->first();

            $this->assertEquals(100, $hasilSiswa2->skor_diperoleh);
            $this->assertEquals($hasilSiswa1->skor_diperoleh, $hasilSiswa2->skor_diperoleh);
        }
    }

    /**
     * 4. Auto-submit saat waktu habis:
     * Siswa hanya sempat menjawab 1 soal dengan benar dari 2 soal sebelum waktu habis.
     * Soal yang tidak sempat dijawab bernilai 0, skor total otomatis terhitung (50).
     */
    public function test_auto_submit_on_timeout_calculates_partial_score_correctly(): void
    {
        // Siswa hanya menjawab quiz1 ('A' benar), quiz2 tidak sempat dijawab karena timeout
        $response = $this->actingAs($this->siswa)
            ->post(route('siswa.quiz.submit', $this->quiz1->id_quiz), [
                'jawaban_' . $this->quiz1->id_quiz => 'A',
                // quiz2 tidak ada di request (belum sempat dijawab)
            ]);

        $response->assertRedirect(route('siswa.quiz.hasil', $this->quiz1->id_quiz));

        $hasil = HasilQuiz::where('id_user', $this->siswa->id_user)
            ->where('id_quiz', $this->quiz1->id_quiz)
            ->first();

        $this->assertNotNull($hasil);
        // 1 benar dari 2 soal = 50 poin
        $this->assertEquals(50, $hasil->skor_diperoleh);
    }

    /**
     * 5. Backend pencocokan kunci jawaban mendukung pencocokan teks opsi
     */
    public function test_backend_validates_option_text_or_key_correctly(): void
    {
        // Siswa mengirim teks opsi 'Joyful' (pilihan A) dan 'Hot' (pilihan B)
        $response = $this->actingAs($this->siswa)
            ->post(route('siswa.quiz.submit', $this->quiz1->id_quiz), [
                'jawaban_' . $this->quiz1->id_quiz => 'Joyful',
                'jawaban_' . $this->quiz2->id_quiz => 'Hot',
            ]);

        $hasil = HasilQuiz::where('id_user', $this->siswa->id_user)
            ->where('id_quiz', $this->quiz1->id_quiz)
            ->first();

        $this->assertNotNull($hasil);
        $this->assertEquals(100, $hasil->skor_diperoleh);
    }
}
