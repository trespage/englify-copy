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
    Schema::create('jawaban_user', function (Blueprint $table) {
        $table->id('id_jawaban');
        $table->foreignId('id_hasil')->constrained('hasil_quiz', 'id_hasil')->onDelete('cascade');
        $table->foreignId('id_quiz')->constrained('quiz', 'id_quiz')->onDelete('cascade');
        $table->enum('jawaban_user', ['A', 'B', 'C', 'D']);
        $table->boolean('benar');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_user');
    }
};
