<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'role' => 'super_admin',
            'password' => bcrypt('password')
        ]);

        User::create([
            'name' => 'Andi Dwi Putra',
            'email' => 'andi@example.com',
            'role' => 'guru',
            'password' => bcrypt('password')
        ]);

        User::create([
            'name' => 'Budi Setiawan',
            'email' => 'siswa@example.com',
            'role' => 'siswa',
            'password' => bcrypt('password')
        ]);
    }
}