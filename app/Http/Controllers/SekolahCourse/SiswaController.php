<?php

namespace App\Http\Controllers\SekolahCourse;

use App\Http\Controllers\Controller;
use App\Models\Modul;
use App\Models\SekolahCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = SekolahCourse::with('sekolah', 'course', 'guru.user')->where('sekolah_id', Auth::user()->siswa->sekolah_id)->latest()->get();
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('pages.siswa_course.actions', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.siswa_course.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SekolahCourse $sekolahCourse)
    {
        try {
            if (Auth::user()->siswa->sekolah_id !== $sekolahCourse->sekolah_id) {
                Alert::error('Error', 'Anda tidak memiliki akses ke course ini');
                return redirect()->route('guru.course.index');
            }
            $data = $sekolahCourse->modul->load('sekolahCourse.course');
            if (request()->ajax()) {
                return datatables()->of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        return view('pages.siswa_course.modul.actions', compact('row'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('pages.siswa_course.show', compact('sekolahCourse'));
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }
}