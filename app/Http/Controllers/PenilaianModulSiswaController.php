<?php

namespace App\Http\Controllers;

use App\Helpers\TimeHelper;
use App\Models\PenilaianModulSiswa;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Models\SekolahCourse;

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

    public function listJawaban(Request $request, SekolahCourse $sekolahCourse)
    {
        $data = PenilaianModulSiswa::
            whereIn('siswa_id', Siswa::where('sekolah_id', $sekolahCourse->sekolah->id)->whereNull('deleted_at')->select('id'))->
            whereIn('modul_id', $sekolahCourse->modul()->select('id'))->get();
        return datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('namaSiswa', function ($row) {
                $siswa = Siswa::where('id', $row->siswa_id)->withTrashed()->first();
                $user = $siswa->user()->withTrashed()->first();
                return $user->name;
            })
            ->addColumn('kelasSiswa', function ($row) {
                $siswa = Siswa::where('id', $row->siswa_id)->withTrashed()->first();
                return $siswa->kelas->nama_kelas ?? '(user deleted)';
            })
            ->addColumn('courseSiswa', function ($row) {
                return $row->modul->sekolahCourse->course->name;
            })
            ->addColumn('modulSiswa', function ($row) {
                return $row->modul->nama;
            })
            ->addColumn('waktuPengerjaanSiswa', function ($row) {
                return TimeHelper::readable($row->answered_time);
            })
            ->addColumn('nilaiSiswa', function ($row) {
                return $row->point ?? '-';
            })
            ->addColumn('action', function ($row) {
                return view('pages.guru_course.modul.actions_pengerjaan', compact('row'));
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function detail(PenilaianModulSiswa $penilaian)
    {
        return response()->json([
            'data' => $penilaian,
            'modul' => $penilaian->modul
        ]);
    }

    public function beriNilai(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'nilai' => 'required|numeric|max:100|min:45'
        ]);

        if ($validator->fails())
            throw new HttpException(400, $validator->errors()->first());
        $penilaian = PenilaianModulSiswa::where('id', $request->id)->first();
        if (!$penilaian)
            return response()->json(['message' => 'Data tidak ada'], 400);
        $penilaian->update(['point' => $request->nilai]);

        return response()->json(['message' => 'Berhasil mengubah nilai']);
    }
}