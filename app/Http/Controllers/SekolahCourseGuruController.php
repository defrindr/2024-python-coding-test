<?php

namespace App\Http\Controllers;

use App\Models\SekolahCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SekolahCourseGuruController extends Controller
{
    public function index(Request $request)
    {
        $data = SekolahCourse::with('sekolah', 'course', 'guru.user')->where('sekolah_id', Auth::user()->guru->sekolah_id)->where('guru_id', Auth::user()->guru->id)->latest()->get();
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return view('pages.guru_course.index');
    }
}