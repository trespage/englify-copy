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
    Schema::create('progress_materi', function (Blueprint $table) {
        $table->id('id_progress');
        $table->foreignId('id_user')->constrained('users', 'id_user')->onDelete('cascade');
        $table->foreignId('id_materi')->constrained('materi', 'id_materi')->onDelete('cascade');
        $table->enum('status', ['Started', 'Completed'])->default('Started');
        $table->timestamp('started_at')->useCurrent();
        $table->timestamp('completed_at')->nullable();
        $table->unique(['id_user', 'id_materi']); // Mencegah duplikasi
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_materi');
    }
};
