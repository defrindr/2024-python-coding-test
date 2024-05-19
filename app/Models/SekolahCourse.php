<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SekolahCourse extends Model
{
    use HasFactory;

    protected $table = 'sekolah_course';

    protected $fillable = [
        'sekolah_id',
        'course_id',
        'guru_id',
        'pertemuan'
    ];

    public function sekolah()
    {
        return $this->belongsTo(Sekolah::class, 'sekolah_id', 'id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'id');
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class, 'guru_id', 'id');
    }

    public function modul()
    {
        return $this->hasMany(Modul::class, 'sekolah_course_id', 'id');
    }
}