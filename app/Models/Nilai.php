<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    protected $table = 'nilai';

    const TYPE_WAKTU = 'waktu';
    const TYPE_ATTEMPT = 'attempt';

    protected $fillable = [
        'modul_id',
        'tipe',
        'min_value',
        'point',
    ];

    public $timestamps = false;

    public function modul()
    {
        return $this->belongsTo(Modul::class);
    }

    public static function fetchNilaiByWaktu($modulId)
    {
        return self::where('tipe', self::TYPE_WAKTU)->where('modul_id', $modulId)->get();
    }

    public static function fetchNilaiByAttempt($modulId)
    {
        return self::where('tipe', self::TYPE_ATTEMPT)->where('modul_id', $modulId)->get();
    }
}
