<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SekolahController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view sekolah')->only('index');
        $this->middleware('permission:create sekolah')->only('create', 'store');
        $this->middleware('permission:edit sekolah')->only('edit', 'update');
        $this->middleware('permission:delete sekolah')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Sekolah::latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('pages.sekolah.actions', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.sekolah.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.sekolah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:sekolah,nama',
            'npsn' => 'required|unique:sekolah,npsn',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return redirect()->back()->withInput();
        }

        try {
            Sekolah::create($request->all());
            Alert::toast('Data sekolah berhasil ditambahkan!', 'success');
            return redirect()->route('sekolah.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sekolah $sekolah)
    {
        return view('pages.sekolah.edit', compact('sekolah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sekolah $sekolah)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|unique:sekolah,nama,' . $sekolah->id,
            'npsn' => 'required|unique:sekolah,npsn,' . $sekolah->id,
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return redirect()->back()->withInput();
        }

        try {
            $sekolah->update($request->all());
            Alert::toast('Data sekolah berhasil diubah!', 'success');
            return redirect()->route('sekolah.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sekolah $sekolah)
    {
        try {
            $sekolah->delete();
            Alert::toast('Data sekolah berhasil dihapus!', 'success');
            return redirect()->route('sekolah.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}