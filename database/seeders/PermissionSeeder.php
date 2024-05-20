<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'view sekolah']);
        Permission::create(['name' => 'create sekolah']);
        Permission::create(['name' => 'update sekolah']);
        Permission::create(['name' => 'delete sekolah']);

        Permission::create(['name' => 'view siswa']);
        Permission::create(['name' => 'create siswa']);
        Permission::create(['name' => 'update siswa']);
        Permission::create(['name' => 'delete siswa']);

        Permission::create(['name' => 'view guru']);
        Permission::create(['name' => 'create guru']);
        Permission::create(['name' => 'update guru']);
        Permission::create(['name' => 'delete guru']);

        Permission::create(['name' => 'view kelas']);
        Permission::create(['name' => 'create kelas']);
        Permission::create(['name' => 'update kelas']);
        Permission::create(['name' => 'delete kelas']);

        Permission::create(['name' => 'super admin view course']);
        Permission::create(['name' => 'admin view course']);
        Permission::create(['name' => 'create course']);
        Permission::create(['name' => 'update course']);
        Permission::create(['name' => 'delete course']);

        Permission::create(['name' => 'view modul']);
        Permission::create(['name' => 'create modul']);
        Permission::create(['name' => 'update modul']);
        Permission::create(['name' => 'delete modul']);

        Role::create(['name' => 'super_admin'])
            ->givePermissionTo(Permission::all());

        Role::create(['name' => 'admin'])->givePermissionTo([
            'view sekolah',
            'create sekolah',
            'update sekolah',

            'view siswa',
            'create siswa',
            'update siswa',
            'delete siswa',

            'view guru',
            'create guru',
            'update guru',
            'delete guru',

            'view kelas',
            'create kelas',
            'update kelas',
            'delete kelas',

            'admin view course',

            'view modul',
            'create modul',
            'update modul',
            'delete modul',
        ]);

        Role::create(['name' => 'guru'])->givePermissionTo([
            'view siswa',
            'create siswa',
            'update siswa',
            'delete siswa',

            'view kelas',
            'create kelas',
            'update kelas',
            'delete kelas',

            'view guru',
            'create guru',
            'update guru',
            'delete guru',

            'view modul',
            'create modul',
            'update modul',
        ]);

        Role::create(['name' => 'siswa'])->givePermissionTo([
            'view modul',
        ]);
    }
}