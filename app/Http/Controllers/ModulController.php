<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\PenilaianModulSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class ModulController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view modul')->only('index');
        $this->middleware('permission:create modul')->only('store');
        $this->middleware('permission:edit modul')->only('update');
        $this->middleware('permission:delete modul')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:8192'
            ]);

            if ($validator->fails()) {
                Alert::error('Error', $validator->errors()->first());
                return redirect()->back()->withInput();
            }
            $file = $request->file('file');
            $file_name = date('d-m-Y') . '_' . $file->getClientOriginalName();
            $file_path = $file->storeAs('public/modul', $file_name);
            Modul::create([
                'nama' => $file_name,
                'file_path' => $file_path,
                'sekolah_course_id' => $request->sekolah_course_id
            ]);
            return redirect()->route('admin.course.index');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Modul $modul)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modul $modul)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'file' => 'nullable|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:8192'
            ]);

            if ($validator->fails()) {
                Alert::error('Error', $validator->errors()->first());
                return redirect()->back()->withInput();
            }
            $modul = Modul::find($id);
            if ($request->hasFile('file')) {
                if ($modul->file_path) {
                    Storage::delete($modul->file_path);
                }
                $index = $modul->pertemuan;
                $file = $request->file('file');
                $file_name = "Pertemuan-$index" . '_' . $file->getClientOriginalName();
                $file_path = $file->storeAs('public/modul', $file_name);
                $modul->file_path = $file_path;
                $modul->nama = $file_name;
            }
            $modul->save();
            return redirect()->route('admin.course.index');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modul $modul)
    {
        try {
            if ($modul->file_path) {
                Storage::delete($modul->file_path);
            }
            $modul->delete();
            return redirect()->route('admin.course.index');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back();
        }
    }

    public function downloadModul($id)
    {
        $modul = Modul::find($id);
        if (!$modul) {
            Alert::error('Error', 'Modul tidak ditemukan');
            return redirect()->back();
        }
        // if (!PenilaianModulSiswa::where('modul_id', $modul->id)->where('siswa_id', Auth::user()->siswa->id)->exists()) {
        //     PenilaianModulSiswa::create([
        //         'modul_id' => $modul->id,
        //         'siswa_id' => Auth::user()->siswa->id,
        //     ]);
        // }
        return response()->download(storage_path('app/' . $modul->file_path));
    }
}