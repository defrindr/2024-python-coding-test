<?php

namespace App\Http\Controllers\SekolahCourse;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Modul;
use App\Models\Nilai;
use App\Models\PenilaianModulSiswa;
use App\Models\SekolahCourse;
use App\Models\Siswa;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = SekolahCourse::with('sekolah', 'course', 'guru.user')->where('sekolah_id', Auth::user()->guru->sekolah_id)->where('guru_id', Auth::user()->guru->id)->latest()->get();
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('pages.guru_course.actions', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.guru_course.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SekolahCourse $sekolahCourse)
    {
        try {
            if (Auth::user()->guru->sekolah_id !== $sekolahCourse->sekolah_id) {
                Alert::error('Error', 'Anda tidak memiliki akses ke course ini');
                return redirect()->route('guru.course.index');
            }
            $data = $sekolahCourse->modul->load('sekolahCourse.course');
            if (request()->ajax()) {
                return datatables()->of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return view('pages.guru_course.modul.actions', compact('row'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            $pesertaMengerjakan = PenilaianModulSiswa::
                whereIn('siswa_id', Siswa::where('sekolah_id', $sekolahCourse->sekolah->id)->whereNull('deleted_at')->select('id'))
                ->whereIn('modul_id', Modul::where('sekolah_course_id', $sekolahCourse->id)->select('id'))->count();
            $totalPeserta = $sekolahCourse->sekolah->siswa()->count();
            $data = [$pesertaMengerjakan, $totalPeserta - $pesertaMengerjakan];

            return view('pages.guru_course.show', compact('sekolahCourse', 'data'));
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SekolahCourse $sekolahCourse)
    {
        try {
            if (Auth::user()->guru->sekolah_id !== $sekolahCourse->sekolah_id) {
                Alert::error('Error', 'Anda tidak memiliki akses ke course ini');
                return redirect()->route('admin.course.index');
            }
            $courses = Course::get();
            $moduls = Modul::where('sekolah_course_id', $sekolahCourse->id)->get()->groupBy('pertemuan');
            return view('pages.guru_course.edit', compact('sekolahCourse', 'courses', 'moduls'));
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function editKunciJawaban(string $id)
    {
        try {

            $data = Modul::findOrFail($id);

            return view('pages.guru_course.modul.jawaban', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->withInput();
        }
    }

    public function updateKunciJawaban(Request $request, string $id)
    {
        try {
            $modul = Modul::findOrFail($id);
            $modul->update([
                'kunci_jawaban' => $request->input('kunci_jawaban'),
                'kode_program' => $request->input('kode_program'),
            ]);

            return response()->json(['status' => 'success']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 'error', 'message' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SekolahCourse $sekolahCourse)
    {
        try {
            if (Auth::user()->guru->sekolah_id !== $sekolahCourse->sekolah_id) {
                Alert::error('Error', 'Anda tidak memiliki akses ke course ini');
                return redirect()->back()->withInput();
            }
            $validator = Validator::make($request->all(), [
                'file.*.*' => 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:8192',
            ]);

            if ($validator->fails()) {
                Alert::error('Error', $validator->errors()->first());
                return redirect()->back()->withInput();
            }

            $arrayKeys = array_keys($request->file);
            foreach ($arrayKeys as $key) {
                for ($j = 0; $j < 3; $j++) {
                    if ($request->hasFile("file.$key.$j")) {
                        $index = $key + 1;
                        $file = $request->file("file.$key.$j");
                        $file_name = "Pertemuan-$index" . '_' . $file->getClientOriginalName();
                        $file_path = $file->storeAs('public/modul', $file_name);
                        $modul = Modul::create([
                            'nama' => $file_name,
                            'file_path' => $file_path,
                            'sekolah_course_id' => $sekolahCourse->id,
                            'pertemuan' => $index
                        ]);

                        $tipeAttempt = Nilai::where('modul_id', $modul->id)->where('tipe', Nilai::TYPE_ATTEMPT)->get();
                        $tipeWaktu = Nilai::where('modul_id', $modul->id)->where('tipe', Nilai::TYPE_WAKTU)->get();

                        if (count($tipeWaktu) == 0) {
                            $values = [[10, 100], [20, 80], [25, 70], [30, 60], [40, 50]];
                            foreach ($values as $value)
                                Nilai::create([
                                    'modul_id' => $modul->id,
                                    'tipe' => Nilai::TYPE_WAKTU,
                                    'min_value' => $value[0],
                                    'point' => $value[1]
                                ]);
                            $tipeWaktu = Nilai::where('modul_id', $modul->id)->where('tipe', Nilai::TYPE_WAKTU)->get();
                        }

                        if (count($tipeAttempt) == 0) {
                            $values = [[3, 100], [5, 80], [7, 70], [9, 60], [11, 50]];
                            foreach ($values as $value)
                                Nilai::create([
                                    'modul_id' => $modul->id,
                                    'tipe' => Nilai::TYPE_ATTEMPT,
                                    'min_value' => $value[0],
                                    'point' => $value[1]
                                ]);
                            $tipeAttempt = Nilai::where('modul_id', $modul->id)->where('tipe', Nilai::TYPE_ATTEMPT)->get();
                        }
                    }
                }
            }

            Alert::success('Success', 'Course berhasil diupdate');
            return redirect()->back();
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }


    public function aturNilai(Modul $modul)
    {
        $tipeAttempt = Nilai::where('modul_id', $modul->id)->where('tipe', Nilai::TYPE_ATTEMPT)->get();
        $tipeWaktu = Nilai::where('modul_id', $modul->id)->where('tipe', Nilai::TYPE_WAKTU)->get();

        if (count($tipeWaktu) == 0) {
            $values = [[10, 100], [20, 80], [25, 70], [30, 60], [40, 50]];
            foreach ($values as $value)
                Nilai::create([
                    'modul_id' => $modul->id,
                    'tipe' => Nilai::TYPE_WAKTU,
                    'min_value' => $value[0],
                    'point' => $value[1]
                ]);
            $tipeWaktu = Nilai::where('modul_id', $modul->id)->where('tipe', Nilai::TYPE_WAKTU)->get();
        }

        if (count($tipeAttempt) == 0) {
            $values = [[3, 100], [5, 80], [7, 70], [9, 60], [11, 50]];
            foreach ($values as $value)
                Nilai::create([
                    'modul_id' => $modul->id,
                    'tipe' => Nilai::TYPE_ATTEMPT,
                    'min_value' => $value[0],
                    'point' => $value[1]
                ]);
            $tipeAttempt = Nilai::where('modul_id', $modul->id)->where('tipe', Nilai::TYPE_ATTEMPT)->get();
        }


        return view('pages.guru_course.nilai', compact('modul', 'tipeAttempt', 'tipeWaktu'));
    }

    public function simpanNilai(Modul $modul, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'waktu_min.*' => 'required',
            'waktu_point.*' => 'required',
            'attempt_min.*' => 'required',
            'attempt_point.*' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error('Error', $validator->messages()->first());
            return redirect()->back()->withInput();
        }

        if ($request->has('waktu_hidden')) {
            foreach ($request->get('waktu_hidden') as $index => $waktu) {
                $data = Nilai::where('modul_id', $modul->id)->where('tipe', Nilai::TYPE_WAKTU)->where('id', $waktu)->first();

                $data->update([
                    'min_value' => $request->get('waktu_min')[$index],
                    'point' => $request->get('waktu_point')[$index]
                ]);
            }
        } else {
            foreach ($request->get('waktu_min') as $index => $waktu) {
                Nilai::create([
                    'modul_id' => $modul->id,
                    'tipe' => Nilai::TYPE_WAKTU,
                    'min_value' => $request->get('waktu_min')[$index],
                    'point' => $request->get('waktu_point')[$index]
                ]);
            }
        }

        if ($request->has('attempt_hidden')) {
            foreach ($request->get('attempt_hidden') as $index => $attempt) {
                $data = Nilai::where('modul_id', $modul->id)->where('tipe', Nilai::TYPE_ATTEMPT)->where('id', $attempt)->first();

                $data->update([
                    'min_value' => $request->get('attempt_min')[$index],
                    'point' => $request->get('attempt_point')[$index]
                ]);
            }
        } else {
            foreach ($request->get('attempt_min') as $index => $attempt) {
                Nilai::create([
                    'modul_id' => $modul->id,
                    'tipe' => Nilai::TYPE_ATTEMPT,
                    'min_value' => $request->get('attempt_min')[$index],
                    'point' => $request->get('attempt_point')[$index]
                ]);
            }
        }

        return redirect()->back();
    }
}
