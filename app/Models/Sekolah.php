<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolah';

    protected $fillable = [
        'nama',
        'npsn',
        'alamat',
    ];

    public function guru()
    {
        return $this->hasMany(Guru::class, 'sekolah_id', 'id');
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'sekolah_id', 'id');
    }

    public function admin()
    {
        return $this->hasMany(Admin::class, 'sekolah_id', 'id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'sekolah_id', 'id');
    }

    public function sekolahcourse()
    {
        return $this->hasMany(SekolahCourse::class, 'sekolah_id', 'id');
    }
}