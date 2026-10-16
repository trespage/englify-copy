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
    Schema::create('users', function (Blueprint $table) {
        $table->id('id_user');
        $table->foreignId('id_role')->constrained('roles', 'id_role')->onDelete('cascade');
        $table->foreignId('id_kategori')->nullable()->constrained('kategori', 'id_kategori')->onDelete('set null');
        $table->string('nama');
        $table->string('username', 100)->unique();
        $table->string('email')->unique();
        $table->string('password');
        $table->string('status', 20)->default('aktif');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
