<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('quiz', function (Blueprint $table) {
            $table->id('id_quiz');
            $table->foreignId('id_materi')->nullable()->constrained('materi', 'id_materi')->onDelete('cascade');
            $table->foreignId('id_bab')->nullable()->constrained('bab', 'id')->onDelete('set null');
            $table->text('pertanyaan');
            $table->string('pilihan_a');
            $table->string('pilihan_b');
            $table->string('pilihan_c');
            $table->string('pilihan_d');
            $table->string('audio', 255)->nullable();
            $table->string('audio_title', 255)->nullable();
            $table->text('audio_petunjuk')->nullable();
            $table->enum('kunci_jawaban', ['A', 'B', 'C', 'D']);
            $table->integer('poin')->default(10);
            $table->string('status', 20)->default('Aktif');
            $table->integer('urutan')->nullable();
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
