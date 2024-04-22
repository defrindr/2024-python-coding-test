<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function sekolah()
    {
        return $this->belongsToMany(Sekolah::class, 'sekolah_course', 'course_id', 'sekolah_id');
    }
}