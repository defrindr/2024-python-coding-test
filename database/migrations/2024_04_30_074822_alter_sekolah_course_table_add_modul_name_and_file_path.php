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
        Schema::table('sekolah_course', function (Blueprint $table) {
            $table->json('modul_name')->nullable()->after('guru_id');
            $table->json('file_path')->nullable()->after('modul_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sekolah_course', function (Blueprint $table) {
            $table->dropColumn('modul_name');
            $table->dropColumn('file_path');
        });
    }
};