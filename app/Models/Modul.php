<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    use HasFactory;

    protected $table = 'modul';

    protected $fillable = [
        'nama',
        'file_path',
        'sekolah_course_id',
        'pertemuan',
        'kunci_jawaban',
        'kode_program',
    ];

    public function sekolahCourse()
    {
        return $this->belongsTo(SekolahCourse::class, 'sekolah_course_id', 'id');
    }

    public function penilaianModulSiswa()
    {
        return $this->hasMany(PenilaianModulSiswa::class);
    }
}
