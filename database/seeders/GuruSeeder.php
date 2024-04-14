<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Guru::create([
            'user_id' => 2,
            'sekolah_id' => 1,
            'nip' => '1234567890',
            'alamat' => 'Jl. Raya No. 1',
            'mata_pelajaran' => 'Matematika'
        ]);
    }
}