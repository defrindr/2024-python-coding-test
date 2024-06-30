<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianModulSiswa extends Model
{
    use HasFactory;

    protected $table = 'penilaian_modul_siswa';

    protected $fillable = [
        'modul_id',
        'siswa_id',
        'source',
        'output',
        'answered_time', 
        'raw_result',
        'attempt',
        'point',
        'is_upload_tugas',
    ];

    public function modul()
    {
        return $this->belongsTo(Modul::class);
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}