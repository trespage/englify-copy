<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
    Schema::create('hasil_quiz', function (Blueprint $table) {
        $table->id('id_hasil');
        $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
        $table->foreignId('id_materi')->constrained('materi', 'id_materi')->onDelete('cascade');
        $table->integer('skor_total')->default(0);
        $table->unique(['id_user', 'id_materi']); // Mencegah pengerjaan ganda
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_quiz');
    }
};
