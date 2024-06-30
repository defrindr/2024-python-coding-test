<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\PenilaianModulSiswa;
use Illuminate\Http\Request;

class PythonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(String $id)
    {

        $data = Modul::findOrFail($id);
        $answer = PenilaianModulSiswa::where('modul_id', $id)->where('siswa_id', auth()->user()->siswa->id)->first();
        if($answer && $answer->is_upload_tugas) {
            return view('pages.course_python.course_python_readonly', compact('data','answer'));
        }
        return view('pages.course_python.course_python', compact('data','answer'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
