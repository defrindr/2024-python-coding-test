<?php

namespace App\Helpers;

class TimeHelper
{
    public static function readable($second)
    {
        $jam = floor($second / 3600);
        $menit = $second % 3600;
        $detik = $menit % 60;
        $menit = floor($menit / 60);

        $readable = "";
        if ($jam) {
            $readable .= $jam . " Jam";
        }

        if ($menit) {
            if ($readable != '')
                $readable .= " ";
            $readable .= $menit . " Menit";
        }

        if ($detik) {
            if ($readable != '')
                $readable .= " ";
            $readable .= $detik . " Detik";
        }

        if ($readable == '') return '-';


        return $readable;
    }
}