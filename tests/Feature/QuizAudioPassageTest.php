<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Bab;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\ProgressMateri;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class QuizAudioPassageTest extends TestCase
{
    protected ?User $admin = null;
    protected ?User $siswa = null;
    protected ?Kategori $kategori = null;
    protected ?Bab $bab = null;
    protected ?Materi $materi = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::where('id_role', 2)->first() ?? User::where('id_role', 1)->first();
        $this->siswa = User::where('id_role', 3)->first();
        if ($this->siswa) {
            $this->siswa->must_change_password = 0;
            $this->siswa->saveQuietly();
        }

        $this->kategori = Kategori::where('nama_kategori', 'Listening')->first() ?? Kategori::first();

        $this->bab = Bab::firstOrCreate(
            ['id_kategori' => $this->kategori->id_kategori, 'judul' => 'Pengujian Audio Passage Bab'],
            ['urutan' => 991, 'durasi_menit' => 15, 'is_active' => true]
        );

        $this->materi = Materi::firstOrCreate(
            ['id_bab' => $this->bab->id, 'judul' => 'Pengujian Audio Passage Materi'],
            [
                'id_kategori' => $this->kategori->id_kategori,
                'id_admin'    => $this->admin->id_user,
                'bab'         => '1',
                'urutan'      => 1,
                'status'      => 'Published',
                'deskripsi'   => 'Deskripsi uji audio passage',
                'isi_materi'  => 'Konten bacaan pengujian audio passage',
            ]
        );

        if ($this->siswa) {
            ProgressMateri::firstOrCreate(
                ['id_user' => $this->siswa->id_user, 'id_materi' => $this->materi->id_materi],
                ['status' => 'Completed', 'started_at' => now(), 'completed_at' => now()]
            );
        }
    }

    protected function tearDown(): void
    {
        // Cleanup test data
        if ($this->materi) {
            Quiz::where('id_materi', $this->materi->id_materi)->delete();
            ProgressMateri::where('id_materi', $this->materi->id_materi)->delete();
            $this->materi->delete();
        }
        if ($this->bab) {
            $this->bab->delete();
        }

        parent::tearDown();
    }

    /**
     * 1. Halaman admin quiz memuat daftar audio yang tersedia di folder quiz_audio
     */
    public function test_admin_quiz_page_lists_available_audios(): void
    {
        $response = $this->actingAs($this->admin)->get(route('admin.quiz'));
        $response->assertStatus(200);
        $response->assertViewHas('audioFiles');
    }

    /**
     * 2. Admin dapat menyimpan soal quiz dengan memilih audio yang ada (Audio Passage)
     */
    public function test_admin_can_create_quiz_with_existing_audio(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.quiz.store'), [
            'id_materi'      => $this->materi->id_materi,
            'id_bab'         => $this->bab->id,
            'pertanyaan'     => 'What is the speaker talking about?',
            'pilihan_a'      => 'Morning coffee',
            'pilihan_b'      => 'Night train',
            'pilihan_c'      => 'Airport security',
            'pilihan_d'      => 'Hotel booking',
            'kunci_jawaban'  => 'A',
            'poin'           => 50,
            'status'         => 'Aktif',
            'audio_existing' => 'quiz_audio/listening_bab1_story.mp3',
            'audio_title'    => 'Passage 1: Morning Routine',
            'audio_petunjuk' => 'Dengarkan percakapan untuk menjawab soal 1 - 2.',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('quiz', [
            'id_materi'   => $this->materi->id_materi,
            'audio'       => 'quiz_audio/listening_bab1_story.mp3',
            'audio_title' => 'Passage 1: Morning Routine',
        ]);
    }

    /**
     * 3. Siswa yang membuka kuis menerima audio passage range dan URL pemutar audio yang tepat
     */
    public function test_siswa_receives_audio_passage_payload(): void
    {
        // Buat 2 soal berurutan dengan audio passage yang sama
        $q1 = Quiz::create([
            'id_materi'      => $this->materi->id_materi,
            'id_bab'         => $this->bab->id,
            'pertanyaan'     => 'Listening question 1?',
            'pilihan_a'      => 'Option A',
            'pilihan_b'      => 'Option B',
            'pilihan_c'      => 'Option C',
            'pilihan_d'      => 'Option D',
            'kunci_jawaban'  => 'A',
            'poin'           => 50,
            'status'         => 'Aktif',
            'urutan'         => 1,
            'audio'          => 'quiz_audio/listening_bab1_story.mp3',
            'audio_title'    => 'Shared Dialog Passage',
            'audio_petunjuk' => 'Listen carefully.',
        ]);

        $q2 = Quiz::create([
            'id_materi'      => $this->materi->id_materi,
            'id_bab'         => $this->bab->id,
            'pertanyaan'     => 'Listening question 2?',
            'pilihan_a'      => 'Option A',
            'pilihan_b'      => 'Option B',
            'pilihan_c'      => 'Option C',
            'pilihan_d'      => 'Option D',
            'kunci_jawaban'  => 'B',
            'poin'           => 50,
            'status'         => 'Aktif',
            'urutan'         => 2,
            'audio'          => 'quiz_audio/listening_bab1_story.mp3',
            'audio_title'    => 'Shared Dialog Passage',
            'audio_petunjuk' => 'Listen carefully.',
        ]);

        $response = $this->actingAs($this->siswa)->get(route('siswa.quiz.kerjakan', $q1->id_quiz));
        $response->assertStatus(200);

        // Periksa questionsPayload memuat audio dan shared passage range
        $payload = $response->viewData('questionsPayload');
        $this->assertNotEmpty($payload);

        $firstItem = $payload[0];
        $this->assertNotNull($firstItem['audio']);
        $this->assertStringContainsString('listening_bab1_story.mp3', $firstItem['audio']);
        $this->assertTrue($firstItem['is_shared_passage']);
        $this->assertEquals('Soal 1 – 2', $firstItem['passage_range']);

        // Periksa bahwa tampilan memuat elemen audio container
        $response->assertSee('id="audioPassageContainer"', false);
    }
}
