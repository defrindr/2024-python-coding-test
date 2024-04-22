<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Guru;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Course::latest()->get();
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('pages.course.actions', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.course.index');
    }

    public function adminIndex(Request $request)
    {
        // get data from pivot table sekolah_course
        $data = Course::with('sekolah')->where('id', Auth::user()->sekolah_id)->latest()->get();
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
        return view('pages.course.create');
    }

    /**
     * Take course
     */

    public function createTakeCourse()
    {
        $courses = Course::whereDoesntHave('sekolah', function ($query) {
            $query->where('sekolah_id', Auth::user()->sekolah_id);
        })->get();
        return view('pages.admin_course.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
            ]);

            if ($validator->fails()) {
                Alert::error('Error', $validator->errors()->first());
                return redirect()->back()->withInput();
            }

            Course::create([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            Alert::success('Success', 'Course created successfully');
            return redirect()->route('course.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    public function storeTakeCourse($id)
    {
        try {
            $course = Course::find($id);
            $sekolah = Sekolah::find(Auth::user()->sekolah_id);
            $course->sekolah()->attach($sekolah);

            Alert::success('Success', 'Course taken successfully');
            return redirect()->route('admin.course.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('pages.course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'description' => 'required',
            ]);

            if ($validator->fails()) {
                Alert::error('Error', $validator->errors()->first());
                return redirect()->back()->withInput();
            }

            $course->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);

            Alert::success('Success', 'Course updated successfully');
            return redirect()->route('course.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            $course->delete();
            Alert::success('Success', 'Course deleted successfully');
            return redirect()->route('course.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }
}