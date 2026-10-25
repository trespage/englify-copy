<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Bab;
use App\Models\Materi;
use App\Models\Quiz;
use App\Models\ProgressMateri;

class AdminRevisionsSpecificTest extends TestCase
{
    protected ?User $admin = null;
    protected ?User $siswa = null;
    protected ?Kategori $kategori = null;

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
    }

    protected function tearDown(): void
    {
        $this->cleanupTestData();
        parent::tearDown();
    }

    protected function cleanupTestData(): void
    {
        Bab::where('judul', 'like', 'Bab Uji %')
            ->orWhere('judul', 'like', 'Bab Non-Aktif %')
            ->delete();

        Materi::where('judul', 'like', 'Materi Khusus %')
            ->orWhere('judul', 'like', 'Materi Tersembunyi %')
            ->orWhere('judul', 'like', 'Materi Multi %')
            ->delete();
    }

    /**
     * Revisi 1: Tombol "Lihat semua >" pada card Aktivitas Terbaru di Dashboard Admin dihapus.
     */
    public function test_dashboard_admin_removes_lihat_semua_button(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Aktivitas Terbaru');

        $content = $response->getContent();
        // Header card Aktivitas Terbaru tidak memiliki link Lihat semua
        $this->assertMatchesRegularExpression('/Aktivitas Terbaru<\/h3>\s*<\/div>\s*<\/div>/', $content);
    }

    /**
     * Revisi 2: Batas Waktu Quiz (Timer) dikelola per-materi dengan durasi_menit.
     */
    public function test_timer_quiz_is_per_materi(): void
    {
        $bab = Bab::create([
            'id_kategori' => $this->kategori->id_kategori,
            'judul'       => 'Bab Uji Timer Materi',
            'urutan'      => 901,
            'is_active'   => true,
            'durasi_menit'=> 15,
        ]);

        $materi = Materi::create([
            'id_admin'     => $this->admin->id_user,
            'id_kategori'  => $this->kategori->id_kategori,
            'id_bab'       => $bab->id,
            'bab'          => $bab->judul,
            'judul'        => 'Materi Khusus Timer 45 Menit',
            'isi_materi'   => 'Isi materi dengan durasi kuis 45 menit',
            'status'       => 'Published',
            'durasi_menit' => 45,
            'urutan'       => 1,
        ]);

        $quiz = Quiz::create([
            'id_bab'        => $bab->id,
            'id_materi'     => $materi->id_materi,
            'pertanyaan'    => 'Pertanyaan timer?',
            'pilihan_a'     => 'A',
            'pilihan_b'     => 'B',
            'pilihan_c'     => 'C',
            'pilihan_d'     => 'D',
            'kunci_jawaban' => 'A',
            'status'        => 'Aktif',
            'urutan'        => 1,
        ]);

        // Siswa membaca materi
        ProgressMateri::firstOrCreate(
            ['id_user' => $this->siswa->id_user, 'id_materi' => $materi->id_materi],
            ['status' => 'Completed']
        );

        $response = $this->actingAs($this->siswa)->get("/siswa/quiz/{$quiz->id_quiz}");
        $response->assertStatus(200);
        $response->assertViewHas('durasiMenit', 45);

        // Cleanup
        $quiz->delete();
        $materi->delete();
        $bab->delete();
    }

    /**
     * Revisi 3: Fungsionalitas Centang Aktifkan Bab & Hirarki Status Bab -> Materi -> Quiz
     */
    public function test_bab_active_toggle_and_hierarchy_status_for_siswa(): void
    {
        // 1. Uji toggle simpan status aktif bab di MySQL
        $response = $this->actingAs($this->admin)->post(route('admin.bab.store'), [
            'id_kategori' => $this->kategori->id_kategori,
            'judul'       => 'Bab Non-Aktif Testing',
            'urutan'      => 902,
            // is_active tidak dikirim (checkbox tidak dicentang)
        ]);

        $createdBab = Bab::where('judul', 'Bab Non-Aktif Testing')->latest('id')->first();
        $this->assertNotNull($createdBab);
        $this->assertFalse((bool)$createdBab->is_active);

        // 2. Buat Materi dengan status 'Published' di dalam Bab Non-Aktif tersebut
        $materi = Materi::create([
            'id_admin'     => $this->admin->id_user,
            'id_kategori'  => $this->kategori->id_kategori,
            'id_bab'       => $createdBab->id,
            'bab'          => $createdBab->judul,
            'judul'        => 'Materi Tersembunyi Karena Bab Nonaktif',
            'isi_materi'   => 'Konten tersembunyi',
            'status'       => 'Published',
            'urutan'       => 1,
        ]);

        $quiz = Quiz::create([
            'id_bab'        => $createdBab->id,
            'id_materi'     => $materi->id_materi,
            'pertanyaan'    => 'Quiz tersembunyi?',
            'pilihan_a'     => 'A',
            'pilihan_b'     => 'B',
            'pilihan_c'     => 'C',
            'pilihan_d'     => 'D',
            'kunci_jawaban' => 'A',
            'status'        => 'Aktif',
            'urutan'        => 1,
        ]);

        // Karena Bab non-aktif, Materi tidak boleh lolos scope visibleForSiswa
        $this->assertFalse(Materi::visibleForSiswa()->where('id_materi', $materi->id_materi)->exists());
        $this->assertFalse(Quiz::visibleForSiswa()->where('id_quiz', $quiz->id_quiz)->exists());

        // Siswa mengakses URL materi langsung -> Harus diredirect karena bab non-aktif
        $resBaca = $this->actingAs($this->siswa)->get("/siswa/materi/{$materi->id_materi}");
        $resBaca->assertRedirect(route('siswa.materi'));

        // Siswa mengakses quiz langsung -> Harus diredirect karena bab non-aktif
        $resQuiz = $this->actingAs($this->siswa)->get("/siswa/quiz/{$quiz->id_quiz}");
        $resQuiz->assertRedirect(route('siswa.peta-quiz'));

        // 3. Aktifkan bab, tapi ubah materi menjadi 'Draft'
        $createdBab->update(['is_active' => true]);
        $materi->update(['status' => 'Draft']);

        // Materi Draft tidak boleh visible untuk siswa
        $this->assertFalse(Materi::visibleForSiswa()->where('id_materi', $materi->id_materi)->exists());
        // Quiz dari Materi Draft juga otomatis tersembunyi
        $this->assertFalse(Quiz::visibleForSiswa()->where('id_quiz', $quiz->id_quiz)->exists());

        // Cleanup
        $quiz->delete();
        $materi->delete();
        $createdBab->delete();
    }

    /**
     * Revisi 4: Support Multiple URLs & Penghapusan Upload Dokumen
     */
    public function test_multiple_urls_supported_and_document_upload_removed(): void
    {
        $bab = Bab::create([
            'id_kategori' => $this->kategori->id_kategori,
            'judul'       => 'Bab Uji Multiple URLs',
            'urutan'      => 903,
            'is_active'   => true,
        ]);

        $urls = [
            'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'https://dictionary.cambridge.org',
            'https://www.bbc.co.uk/learningenglish'
        ];

        // Simpan materi via Controller / Model dengan input array urls
        $response = $this->actingAs($this->admin)->post(route('admin.materi.store'), [
            'id_kategori'  => $this->kategori->id_kategori,
            'id_bab'       => $bab->id,
            'judul'        => 'Materi Multi URLs',
            'deskripsi'    => 'Deskripsi materi',
            'isi_materi'   => 'Isi materi',
            'status'       => 'Published',
            'durasi_menit' => 20,
            'urls'         => $urls,
        ]);

        $materi = Materi::where('judul', 'Materi Multi URLs')->first();
        $this->assertNotNull($materi);
        $this->assertEquals($urls, $materi->urls_list);

        // Halaman admin materi tidak boleh memuat form input file upload document
        $resAdmin = $this->actingAs($this->admin)->get('/admin/materi');
        $resAdmin->assertDontSee('name="file"', false);
        $resAdmin->assertDontSee('Upload Dokumen');

        // Halaman baca materi siswa menampilkan tautan yang diinput
        $resBaca = $this->actingAs($this->siswa)->get("/siswa/materi/{$materi->id_materi}");
        $resBaca->assertStatus(200);
        $resBaca->assertSee('dQw4w9WgXcQ');
        $resBaca->assertSee('dictionary.cambridge.org');

        // Cleanup
        $materi->delete();
        $bab->delete();
    }

    /**
     * Revisi 5: Kontras Warna Teks pada Tampilan / Switch POV
     */
    public function test_pov_text_contrast_classes_present(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/materi');
        $response->assertStatus(200);

        // Pastikan title POV dan deskripsi top bar memiliki kontras jelas
        $response->assertSee('Pratinjau Materi (POV Siswa)');
        $response->assertSee('text-slate-800');
        $response->assertSee('text-slate-600');
        $response->assertDontSee('from-navy-950 via-slate-900 to-navy-900 text-white');
    }
}
