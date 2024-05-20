<?php

namespace App\Http\Controllers\SekolahCourse;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Guru;
use App\Models\Modul;
use App\Models\SekolahCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = SekolahCourse::with('sekolah', 'course', 'guru.user')->where('sekolah_id', Auth::user()->admin->sekolah_id)->latest()->get();
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('pages.admin_course.actions', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.admin_course.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::get();
        $guru = Guru::with('user')->where('sekolah_id', Auth::user()->admin->sekolah_id)->get();
        return view('pages.admin_course.create', compact('courses', 'guru'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required',
                'guru_id' => 'required',
                'pertemuan' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                Alert::error('Error', $validator->errors()->first());
                return redirect()->back()->withInput();
            }

            if (SekolahCourse::where('sekolah_id', Auth::user()->admin->sekolah_id)->where('course_id', $request->course_id)->where('guru_id', $request->guru_id)->exists()) {
                Alert::error('Error', 'Course sudah terdaftar pada guru ini');
                return redirect()->back()->withInput();
            }

            SekolahCourse::create([
                'sekolah_id' => Auth::user()->admin->sekolah_id,
                'course_id' => $request->course_id,
                'guru_id' => $request->guru_id,
                'pertemuan' => $request->pertemuan
            ]);

            Alert::success('Success', 'Course berhasil ditambahkan');
            return redirect()->route('admin.course.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    /**
     * Display the specified resource.
     */
    public function show(SekolahCourse $sekolahCourse)
    {
        try {
            if (Auth::user()->admin->sekolah_id !== $sekolahCourse->sekolah_id) {
                Alert::error('Error', 'Anda tidak memiliki akses ke course ini');
                return redirect()->route('admin.course.index');
            }
            $data = $sekolahCourse->modul->load('sekolahCourse.course');
            if (request()->ajax()) {
                return datatables()->of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return view('pages.admin_course.modul.actions', compact('row'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('pages.admin_course.show', compact('sekolahCourse'));
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
            if (Auth::user()->admin->sekolah_id !== $sekolahCourse->sekolah_id) {
                Alert::error('Error', 'Anda tidak memiliki akses ke course ini');
                return redirect()->route('admin.course.index');
            }
            $courses = Course::get();
            $guru = Guru::with('user')->where('sekolah_id', Auth::user()->admin->sekolah_id)->get();
            $moduls = Modul::where('sekolah_course_id', $sekolahCourse->id)->get();
            return view('pages.admin_course.edit', compact('sekolahCourse', 'courses', 'guru', 'moduls'));
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SekolahCourse $sekolahCourse)
    {
        try {
            if (Auth::user()->admin->sekolah_id !== $sekolahCourse->sekolah_id) {
                Alert::error('Error', 'Anda tidak memiliki akses ke course ini');
                return redirect()->back()->withInput();
            }
            $validator = Validator::make($request->all(), [
                'course_id' => 'required',
                'guru_id' => 'required',
                'pertemuan' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                Alert::error('Error', $validator->errors()->first());
                return redirect()->back()->withInput();
            }

            $sekolahCourse->update([
                'course_id' => $request->course_id,
                'guru_id' => $request->guru_id,
                'pertemuan' => $request->pertemuan
            ]);

            Alert::success('Success', 'Course berhasil diupdate');
            return redirect()->route('admin.course.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SekolahCourse $sekolahCourse)
    {
        try {
            if (Auth::user()->admin->sekolah_id !== $sekolahCourse->sekolah_id) {
                Alert::error('Error', 'Anda tidak memiliki akses ke course ini');
                return redirect()->back()->withInput();
            }
            Modul::where('sekolah_course_id', $sekolahCourse->id)->delete();
            $sekolahCourse->delete();
            Alert::success('Success', 'Course berhasil dihapus');
            return redirect()->route('admin.course.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }
}