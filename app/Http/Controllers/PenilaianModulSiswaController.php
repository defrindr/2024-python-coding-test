<?php

namespace App\Http\Controllers;

use App\Models\PenilaianModulSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;

class PenilaianModulSiswaController extends Controller
{
    public function saveJawaban(Request $request, int $modulId)
    {
        $validator = Validator::make($request->all(), [
            'source' => 'required',
            // 'output' => 'required',
            'raw_result' => 'required',
            'attempt' => 'required',
            'answered_time' => 'required'
        ]);


        if ($validator->fails())
            throw new HttpException(400, $validator->errors()->first());

        $payloads = $validator->validated();

        $payloads['modul_id'] = $modulId;
        $payloads['siswa_id'] = auth()->user()->siswa->id;
        $payloads['is_upload_tugas'] = 0;

        if (!isset($payloads['output'])) {
            $payloads['output'] = "";
        }

        $data = PenilaianModulSiswa::where('modul_id', $modulId)->where('siswa_id', auth()->user()->siswa->id)->first();
        if ($data)
            $data->update($payloads);
        else
            PenilaianModulSiswa::create($payloads);

        return response()->json(['message' => 'Berhasil menyimpan jawaban']);
    }
    public function submitJawaban(Request $request, int $modulId)
    {
        $validator = Validator::make($request->all(), [
            'source' => 'required',
            'output' => 'required',
            'raw_result' => 'required',
            'attempt' => 'required',
            'answered_time' => 'required'
        ]);


        if ($validator->fails())
            throw new HttpException(400, $validator->errors()->first());

        $payloads = $validator->validated();

        $payloads['modul_id'] = $modulId;
        $payloads['siswa_id'] = auth()->user()->siswa->id;
        $payloads['is_upload_tugas'] = 1;

        $data = PenilaianModulSiswa::where('modul_id', $modulId)->where('siswa_id', auth()->user()->siswa->id)->first();
        if ($data)
            $data->update($payloads);
        else
            PenilaianModulSiswa::create($payloads);

        return response()->json(['message' => 'Berhasil menyimpan jawaban']);
    }
}