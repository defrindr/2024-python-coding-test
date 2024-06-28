<?php

namespace App\Http\Controllers\SekolahCourse;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Modul;
use App\Models\SekolahCourse;
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
            return view('pages.guru_course.show', compact('sekolahCourse'));
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

    public function editKunciJawaban(String $id)
    {
        try {

            $data = Modul::findOrFail($id);

            return view('pages.guru_course.modul.jawaban', compact('data'));
        } catch (\Throwable $th) {
            return redirect()->back()->withInput();
        }
    }

    public function updateKunciJawaban(Request $request, String $id)
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
                        Modul::create([
                            'nama' => $file_name,
                            'file_path' => $file_path,
                            'sekolah_course_id' => $sekolahCourse->id,
                            'pertemuan' => $index
                        ]);
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
}
