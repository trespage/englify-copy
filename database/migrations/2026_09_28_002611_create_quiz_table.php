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
    Schema::create('quiz', function (Blueprint $table) {
        $table->id('id_quiz');
        $table->foreignId('id_materi')->constrained('materi', 'id_materi')->onDelete('cascade');
        $table->text('pertanyaan');
        $table->string('pilihan_a');
        $table->string('pilihan_b');
        $table->string('pilihan_c');
        $table->string('pilihan_d');
        $table->enum('kunci_jawaban', ['A', 'B', 'C', 'D']);
        $table->integer('poin')->default(10);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quiz');
    }
};
