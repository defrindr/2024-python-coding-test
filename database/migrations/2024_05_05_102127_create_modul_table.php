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
        Schema::create('modul', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('file_path');
            $table->foreignId('sekolah_course_id')->constrained('sekolah_course');
            $table->integer('pertemuan');
            $table->text('kunci_jawaban')->nullable();
            $table->text('kode_program')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modul');
    }
};
