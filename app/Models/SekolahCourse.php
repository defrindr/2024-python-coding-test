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
        'modul_name',
        'file_path'
    ];

    protected $casts = [
        'modul_name' => 'array',
        'file_path' => 'array'
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
}