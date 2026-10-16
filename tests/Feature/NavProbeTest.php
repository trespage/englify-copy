<?php

namespace Tests\Feature;

use App\Models\HasilQuiz;
use App\Models\Materi;
use App\Models\User;
use Tests\TestCase;

class NavProbeTest extends TestCase
{
    public function test_semua_halaman_navbar_bisa_dibuka(): void
    {
        $superadmin = User::where('id_role', 1)->first();
        $admin = User::where('id_role', 2)->first();
        $siswa = User::where('id_role', 3)->first();
        $this->assertNotNull($superadmin);
        $this->assertNotNull($admin);
        $this->assertNotNull($siswa);

        $materi = Materi::first();
        $hasil = HasilQuiz::first();

        $pages = [
            // [user, method, url/route, label]
            [$superadmin, 'get', route('superadmin.dashboard'), 'superadmin.dashboard'],
            [$superadmin, 'get', route('superadmin.siswa'), 'superadmin.siswa'],
            [$superadmin, 'get', route('superadmin.adminDivisi'), 'superadmin.adminDivisi'],
            [$superadmin, 'get', route('superadmin.settings'), 'superadmin.settings'],
            [$superadmin, 'get', route('superadmin.profile'), 'superadmin.profile'],
            [$admin, 'get', route('admin.dashboard'), 'admin.dashboard'],
            [$admin, 'get', route('admin.kategori'), 'admin.kategori'],
            [$admin, 'get', route('admin.materi'), 'admin.materi'],
            [$admin, 'get', route('admin.quiz'), 'admin.quiz'],
            [$admin, 'get', route('admin.hasil-quiz'), 'admin.hasil-quiz'],
            [$siswa, 'get', route('siswa.dashboard'), 'siswa.dashboard'],
        ];

        if ($materi) {
            $pages[] = [$siswa, 'get', route('siswa.materi.baca', ['id' => $materi->id_materi]), 'siswa.materi.baca'];
        }

        // Siapkan satu rekap hasil untuk menguji halaman detail
        $siswaUser = User::where('id_role', 3)->first();
        $detailHasil = null;
        if ($siswaUser && $materi) {
            $detailHasil = HasilQuiz::updateOrCreate(
                ['id_user' => $siswaUser->id_user, 'id_materi' => $materi->id_materi],
                ['skor_total' => 80]
            );
            $pages[] = [$admin, 'get', route('admin.hasil-quiz.detail', ['id' => $detailHasil->id_hasil]), 'admin.hasil-quiz.detail'];
        }

        // Halaman divisi dialihkan ke admin divisi (placeholder lama)
        $this->actingAs($superadmin)->get(route('superadmin.divisi'))
            ->assertRedirect(route('superadmin.adminDivisi'));

        // CRUD quiz: tambah lalu hapus soal lewat route modal
        if ($materi) {
            $this->actingAs($admin)->post(route('admin.quiz.store'), [
                'id_materi' => $materi->id_materi,
                'pertanyaan' => 'Soal probe navbar?',
                'pilihan_a' => 'A1', 'pilihan_b' => 'B1',
                'pilihan_c' => 'C1', 'pilihan_d' => 'D1',
                'kunci_jawaban' => 'A', 'poin' => 10,
            ])->assertRedirect(route('admin.quiz'));
            $probeQuiz = \App\Models\Quiz::where('pertanyaan', 'Soal probe navbar?')->first();
            $this->assertNotNull($probeQuiz);
            $this->actingAs($admin)->delete(
                route('admin.quiz.destroy', ['id' => $probeQuiz->id_quiz])
            )->assertRedirect(route('admin.quiz'));
        }

        $rusak = [];
        foreach ($pages as [$user, $method, $url, $label]) {
            try {
                $res = $this->actingAs($user)->$method($url);
                $status = $res->getStatusCode();
            } catch (\Throwable $e) {
                $rusak[] = "{$label} => EXCEPTION: " . get_class($e) . ': ' . substr($e->getMessage(), 0, 160);
                continue;
            }
            if ($status !== 200) {
                $rusak[] = "{$label} => status {$status} (URL: {$url})";
                continue;
            }
            if (str_contains($res->getContent() ?? '', 'Implementasi AJAX')) {
                $rusak[] = "{$label} => masih memuat JS dummy";
            }
        }

        $this->assertSame([], $rusak, "Halaman rusak:\n- " . implode("\n- ", $rusak));
    }
}
