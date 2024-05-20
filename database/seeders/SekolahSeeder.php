<?php

namespace Database\Seeders;

use App\Models\Sekolah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SekolahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sekolah::create([
            'nama' => 'SMA Negeri 1 Jakarta',
            'npsn' => '12345678',
            'alamat' => 'Jl. Jend. Sudirman No. 1, Jakarta',
        ]);
    }
}