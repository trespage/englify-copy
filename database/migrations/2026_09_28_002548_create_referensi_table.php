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
    Schema::create('referensi', function (Blueprint $table) {
        $table->id('id_referensi');
        $table->foreignId('id_materi')->constrained('materi', 'id_materi')->onDelete('cascade');
        $table->string('judul_referensi');
        $table->string('url');
        $table->text('deskripsi')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referensi');
    }
};
