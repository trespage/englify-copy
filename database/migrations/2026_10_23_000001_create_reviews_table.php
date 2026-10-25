<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id_user')->on('users')->nullOnDelete();
            $table->string('nama', 100);
            $table->string('role', 100)->default('Siswa Englify');
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('pesan');
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
        });

        // Seed initial curated reviews
        $initialReviews = [
            [
                'nama' => 'Nur Aprilia',
                'role' => 'Siswa English Club',
                'rating' => 5,
                'pesan' => 'Englify sangat membantu aku dalam belajar bahasa Inggris. Materinya lebih mudah dipahami karena sudah dikelompokkan berdasarkan divisi.',
                'is_approved' => true,
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(10),
            ],
            [
                'nama' => 'Ricky Pratama',
                'role' => 'Siswa English Club',
                'rating' => 5,
                'pesan' => 'Platform yang sangat membantu untuk meningkatkan kemampuan bahasa Inggris. Fitur-fiturnya lengkap dan mudah digunakan.',
                'is_approved' => true,
                'created_at' => now()->subDays(8),
                'updated_at' => now()->subDays(8),
            ],
            [
                'nama' => 'Siti Rahma',
                'role' => 'Siswa English Club',
                'rating' => 5,
                'pesan' => 'Saya jadi lebih percaya diri dalam menggunakan bahasa Inggris, terutama untuk speaking. Terima kasih Englify!',
                'is_approved' => true,
                'created_at' => now()->subDays(7),
                'updated_at' => now()->subDays(7),
            ],
            [
                'nama' => 'Andi Firmansyah',
                'role' => 'Siswa English Club',
                'rating' => 5,
                'pesan' => 'Quiz-quiznya seru dan menantang. Bikin belajar jadi nggak bosen sama sekali!',
                'is_approved' => true,
                'created_at' => now()->subDays(6),
                'updated_at' => now()->subDays(6),
            ],
            [
                'nama' => 'Dewi Fitriani',
                'role' => 'Siswa English Club',
                'rating' => 5,
                'pesan' => 'Materinya lengkap dan up-to-date. Recommended banget buat yang mau improve English skill!',
                'is_approved' => true,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
            [
                'nama' => 'Budi Hartono',
                'role' => 'Siswa English Club',
                'rating' => 5,
                'pesan' => 'Progress tracking-nya bikin aku termotivasi buat terus belajar setiap hari!',
                'is_approved' => true,
                'created_at' => now()->subDays(4),
                'updated_at' => now()->subDays(4),
            ],
            [
                'nama' => 'Lina Marlina',
                'role' => 'Siswa English Club',
                'rating' => 5,
                'pesan' => 'UI-nya clean dan mudah dipakai. Nggak ribet buat navigate antar materi.',
                'is_approved' => true,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'nama' => 'Rudi Santoso',
                'role' => 'Siswa English Club',
                'rating' => 5,
                'pesan' => 'Referensi pembelajarannya lengkap banget. Jadi gampang buat deep dive ke topik tertentu.',
                'is_approved' => true,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(2),
            ],
        ];

        DB::table('reviews')->insert($initialReviews);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
