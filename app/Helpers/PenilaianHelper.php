<?php
namespace App\Helpers;

use App\Models\Nilai;
use App\Models\PenilaianModulSiswa;

class PenilaianHelper
{
    public static function HitungNilai($penilaianId)
    {
        $penilaian = PenilaianModulSiswa::find($penilaianId);
        $parameterWaktu = Nilai::fetchNilaiByWaktu($penilaian->modul_id);
        $nilaiWaktu = 0;
        foreach ($parameterWaktu as $waktu) {
            if ($penilaian->answered_time < $waktu->min_value) {
                $nilaiWaktu = $waktu->point;
                break;
            }
        }

        $parameterAttempt = Nilai::fetchNilaiByWaktu($penilaian->modul_id);
        $nilaiAttempt = 0;
        foreach ($parameterAttempt as $attempt) {
            if ($penilaian->answered_time < $attempt->min_value) {
                $nilaiAttempt = $attempt->point;
                break;
            }
        }

        $nilaiTotal = $nilaiWaktu + $nilaiAttempt;

        if ($nilaiTotal == 0) {
            $penilaian->update(['point' => 0]);
        } else {
            $penilaian->update(['point' => $nilaiTotal / 2]);
        }

        return true;
    }
}