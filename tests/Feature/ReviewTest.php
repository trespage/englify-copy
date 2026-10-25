<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Review;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReviewTest extends TestCase
{
    use DatabaseTransactions;
    public function test_guest_can_submit_review(): void
    {
        $response = $this->post('/review', [
            'nama' => 'Bintang Pratama',
            'role' => 'Siswa Kelas 10',
            'rating' => 5,
            'pesan' => 'Website ini sangat interaktif dan menyenangkan untuk belajar grammar!',
        ]);

        $response->assertRedirect('/#ulasan');
        $response->assertSessionHas('review_success');

        $this->assertDatabaseHas('reviews', [
            'nama' => 'Bintang Pratama',
            'role' => 'Siswa Kelas 10',
            'rating' => 5,
        ]);
    }

    public function test_authenticated_user_can_submit_review(): void
    {
        $siswa = User::where('id_role', 3)->first();
        if (!$siswa) {
            $siswa = User::first();
        }

        $response = $this->actingAs($siswa)->post('/review', [
            'nama' => $siswa->nama,
            'role' => 'Siswa English Club',
            'rating' => 5,
            'pesan' => 'Sangat seru dan kuisnya menantang! Bintang lima untuk Englify!',
        ]);

        $response->assertRedirect('/#ulasan');
        $response->assertSessionHas('review_success');

        $this->assertDatabaseHas('reviews', [
            'user_id' => $siswa->id_user,
            'nama' => $siswa->nama,
        ]);
    }

    public function test_review_validation_requires_mandatory_fields(): void
    {
        $response = $this->post('/review', [
            'nama' => '',
            'rating' => 6,
            'pesan' => 'ab',
        ]);

        $response->assertSessionHasErrors(['nama', 'rating', 'pesan']);
    }

    public function test_landing_page_renders_reviews_properly(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Loved by');
        $response->assertSee('Tulis Review Kamu');
        $response->assertSee('Apa Kata Mereka');
        $response->assertSee('testimonial-card');
        $response->assertSee('review-text');
        $response->assertSee('reviewModal');
        $response->assertSee('openReviewModal');
        $response->assertSee('id="ulasan"', false);
    }
}

