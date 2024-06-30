<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:super admin view course')->only('index');
        $this->middleware('permission:admin view course')->only('adminIndex');
        $this->middleware('permission:create course')->only('create', 'store');
        $this->middleware('permission:edit course')->only('edit', 'update');
        $this->middleware('permission:delete course')->only('destroy');
    }

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

            Alert::success('Success', 'Course berhasil ditambahkan');
            return redirect()->route('course.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        $model = \DB::select("select year(penilaian_modul_siswa.created_at) as tahun, sum(case when penilaian_modul_siswa.id is not null then 1 else 0 end) as peserta from courses 
inner join sekolah_course on sekolah_course.course_id=courses.id
inner join modul on modul.sekolah_course_id=sekolah_course.id
inner join penilaian_modul_siswa on penilaian_modul_siswa.modul_id=modul.id
where courses.id = ?
group by year(penilaian_modul_siswa.created_at)", [$course->id]);

        $modelArr = [];

        foreach ($model as $item)
            $modelArr[$item->tahun] = $item->peserta;

        $labels = [];
        $data = [];
        for ($i = date('Y') - 5; $i <= date('Y'); $i++) {
            $labels[] = $i;
            $data[] = isset($modelArr[$i]) ? $modelArr[$i] : 0;
        }

        return view('pages.course.show', compact('course', 'labels', 'data'));
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

            Alert::success('Success', 'Course berhasil diupdate');
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
            Alert::success('Success', 'Course berhasil dihapus');
            return redirect()->route('course.index');
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back();
        }
    }
}