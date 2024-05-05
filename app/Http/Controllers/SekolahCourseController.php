<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Guru;
use App\Models\SekolahCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SekolahCourseController extends Controller
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
                'guru_id' => 'required'
            ]);

            if ($validator->fails()) {
                Alert::error('Error', $validator->errors()->first());
                return redirect()->back()->withInput();
            }

            SekolahCourse::create([
                'sekolah_id' => Auth::user()->admin->sekolah_id,
                'course_id' => $request->course_id,
                'guru_id' => $request->guru_id
            ]);

            Alert::success('Success', 'Course added successfully');
            return redirect()->route('admin.course.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SekolahCourse $sekolahCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SekolahCourse $sekolahCourse)
    {
        $courses = Course::get();
        $guru = Guru::with('user')->where('sekolah_id', Auth::user()->admin->sekolah_id)->get();
        return view('pages.admin_course.edit', compact('courses', 'sekolahCourse', 'guru'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SekolahCourse $sekolahCourse)
    {
        try {
            $validator = Validator::make($request->all(), [
                'course_id' => 'required',
                'guru_id' => 'required'
            ]);

            if ($validator->fails()) {
                Alert::error('Error', $validator->errors()->first());
                return redirect()->back()->withInput();
            }

            $sekolahCourse->course_id = $request->course_id;
            $sekolahCourse->guru_id = $request->guru_id;
            $sekolahCourse->save();

            Alert::success('Success', 'Course updated successfully');
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
            $sekolahCourse->delete();
            Alert::success('Success', 'Course deleted successfully');
            return redirect()->route('admin.course.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }
}