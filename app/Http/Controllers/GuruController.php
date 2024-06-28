<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Modul;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class GuruController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view guru')->only('index');
        $this->middleware('permission:create guru')->only('create', 'store');
        $this->middleware('permission:edit guru')->only('edit', 'update');
        $this->middleware('permission:delete guru')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Auth::user()->role == 'super_admin')
            $data = Guru::with(['user', 'sekolah'])->latest()->get();
        else
            $data = Guru::with(['user', 'sekolah'])->where('sekolah_id', Auth::user()->admin->sekolah_id)->latest()->get();
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('pages.guru.actions', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.guru.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataSekolah = Sekolah::get();
        return view('pages.guru.create', compact('dataSekolah'));
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
            'nip' => 'required|unique:guru,nip',
            'sekolah_id' => 'required',
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
                'role' => 'guru',
            ]);
            $user->assignRole('guru');

            if ($user) {
                Guru::create([
                    'user_id' => $user->id,
                    'sekolah_id' => $request->sekolah_id,
                    'nip' => $request->nip,
                    'alamat' => $request->alamat,
                ]);
                Alert::toast('Data guru berhasil ditambahkan!', 'success');
                if (auth()->user()->role == 'super_admin')
                    return redirect()->route('guru.index');
                else
                    return redirect()->route('admin.guru.index');
            } else {
                $user->delete();
                Alert::toast('Data guru gagal ditambahkan!', 'error');
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
    public function show(Guru $guru)
    {
        $dataSekolah = Sekolah::with('guru')->get();
        return view('pages.guru.show', compact('guru', 'dataSekolah'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $guru)
    {
        $dataSekolah = Sekolah::with('guru')->get();
        $guru->load('guru');
        return view('pages.guru.edit', compact('guru', 'dataSekolah'));
    } 


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $guru)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'alamat' => 'required',
            'nip' => 'required',
            'sekolah_id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return redirect()->back()->withInput();
        }

        try {
            $guru->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
            $guru->guru()->update([
                'nip' => $request->nip,
                'alamat' => $request->alamat,
                'sekolah_id' => $request->sekolah_id,
            ]);
            Alert::toast('Data guru berhasil diubah!', 'success');
            if (auth()->user()->role == 'super_admin')
                return redirect()->route('guru.index');
            else
                return redirect()->route('admin.guru.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $guru)
    {
        try {
            $guru->delete();
            Alert::toast('Data guru berhasil dihapus!', 'success');
            if (auth()->user()->role == 'super_admin')
                return redirect()->route('guru.index');
            else
                return redirect()->route('admin.guru.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}
