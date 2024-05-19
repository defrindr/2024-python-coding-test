<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('penilaian_modul_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('modul_id')->constrained('modul');
            $table->foreignId('siswa_id')->constrained('siswa');
            $table->boolean('is_upload_tugas')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_modul_siswa');
    }
};