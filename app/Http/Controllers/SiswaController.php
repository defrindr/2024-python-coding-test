<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Sekolah;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view siswa')->only('index');
        $this->middleware('permission:create siswa')->only('create', 'store');
        $this->middleware('permission:edit siswa')->only('edit', 'update');
        $this->middleware('permission:delete siswa')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->role == 'super_admin')
            $data = Siswa::with(['user', 'sekolah', 'kelas'])->latest()->get();
        elseif (Auth::user()->role == 'admin')
            $data = Siswa::with(['user', 'sekolah', 'kelas'])->whereHas('sekolah', function ($q) {
                $q->where('id', Auth::user()->admin->sekolah_id);
            })->latest()->get();
        else
            $data = Siswa::with(['user', 'sekolah', 'kelas'])->whereHas('sekolah', function ($q) {
                $q->where('id', Auth::user()->guru->sekolah_id);
            })->latest()->get();

        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('pages.siswa.actions', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.siswa.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataSekolah = Sekolah::all();
        if (Auth::user()->role == 'admin') {
            $idSekolah = Auth::user()->admin->sekolah_id;
            $dataKelas = Kelas::where('sekolah_id', $idSekolah)->get();
        } elseif (Auth::user()->role == 'guru') {
            $idSekolah = Auth::user()->guru->sekolah_id;
            $dataKelas = Kelas::where('sekolah_id', $idSekolah)->get();
        } else {
            $dataKelas = Kelas::all();
        }
        return view('pages.siswa.create', compact('dataSekolah', 'dataKelas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'alamat' => 'required',
            'nis' => 'required|unique:siswa,nis',
            'sekolah_id' => 'required',
            'kelas_id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return redirect()->back()->withInput();
        }

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $user->assignRole('siswa');

            if ($user) {
                Siswa::create([
                    'user_id' => $user->id,
                    'sekolah_id' => $request->sekolah_id,
                    'kelas_id' => $request->kelas_id,
                    'nis' => $request->nis,
                    'alamat' => $request->alamat,
                ]);
                Alert::toast('Data siswa berhasil disimpan', 'success');
                return redirect()->route('siswa.index');
            } else {
                $user->delete();
                Alert::toast('Data siswa gagal disimpan', 'error');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        return view('pages.course_python.course_python');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $dataSekolah = Sekolah::all();
        if (Auth::user()->role == 'admin') {
            $idSekolah = Auth::user()->admin->sekolah_id;
            $dataKelas = Kelas::where('sekolah_id', $idSekolah)->get();
        } elseif (Auth::user()->role == 'guru') {
            $idSekolah = Auth::user()->guru->sekolah_id;
            $dataKelas = Kelas::where('sekolah_id', $idSekolah)->get();
        } else {
            $dataKelas = Kelas::all();
        }

        return view('pages.siswa.edit', compact('siswa', 'dataSekolah', 'dataKelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
            'alamat' => 'required',
            'nis' => 'required|unique:siswa,nis,' . $siswa->id,
            'sekolah_id' => 'required',
            'kelas_id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return redirect()->back()->withInput();
        }

        try {
            $siswa->user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);

            $siswa->update([
                'sekolah_id' => $request->sekolah_id,
                'kelas_id' => $request->kelas_id,
                'nis' => $request->nis,
                'alamat' => $request->alamat,
            ]);

            Alert::toast('Data siswa berhasil diubah', 'success');
            return redirect()->route('siswa.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        try {
            $siswa->delete();
            $siswa->user->delete();
            Alert::toast('Data siswa berhasil dihapus', 'success');
            return redirect()->route('siswa.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}