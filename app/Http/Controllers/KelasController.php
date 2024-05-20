<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class KelasController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view kelas')->only('index');
        $this->middleware('permission:create kelas')->only('create', 'store');
        $this->middleware('permission:edit kelas')->only('edit', 'update');
        $this->middleware('permission:delete kelas')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->role == 'super_admin')
            $data = Kelas::with('sekolah')->latest()->get();
        elseif (Auth::user()->role == 'admin')
            $data = Kelas::with('sekolah')->where('sekolah_id', Auth::user()->admin->sekolah_id)->latest()->get();
        else
            $data = Kelas::with('sekolah')->where('sekolah_id', Auth::user()->guru->sekolah_id)->latest()->get();
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('pages.kelas.actions', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.kelas.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataSekolah = Sekolah::all();
        return view('pages.kelas.create', compact('dataSekolah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required',
            'sekolah_id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return redirect()->back()->withInput();
        }

        try {
            Kelas::create($request->all());
            Alert::toast('Data kelas berhasil ditambahkan!', 'success');
            if (Auth::user()->role == 'super_admin')
                return redirect()->route('kelas.index');
            else
                return redirect()->route('admin.kelas.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        $dataSekolah = Sekolah::all();
        return view('pages.kelas.edit', compact('kelas', 'dataSekolah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required',
            'sekolah_id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return redirect()->back()->withInput();
        }

        try {
            $kelas->update($request->all());
            Alert::toast('Data kelas berhasil diubah!', 'success');
            if (Auth::user()->role == 'super_admin')
                return redirect()->route('kelas.index');
            else
                return redirect()->route('admin.kelas.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        try {
            $kelas->delete();
            Alert::toast('Data kelas berhasil dihapus!', 'success');
            if (Auth::user()->role == 'super_admin')
                return redirect()->route('kelas.index');
            else
                return redirect()->route('admin.kelas.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    public function getKelas(Request $request)
    {
        $sekolahId = $request->input('sekolah_id');
        $data = Kelas::where('sekolah_id', $sekolahId)->get();
        return response()->json($data);
    }
}