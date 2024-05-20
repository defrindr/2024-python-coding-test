<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Sekolah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Admin::with(['user', 'sekolah'])->latest()->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('pages.admin.actions', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.admin.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $dataSekolah = Sekolah::all();
        return view('pages.admin.create', compact('dataSekolah'));
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
                'role' => 'admin',
                'password' => bcrypt($request->password),
            ]);
            $user->assignRole('admin');

            Admin::create([
                'user_id' => $user->id,
                'sekolah_id' => $request->sekolah_id,
            ]);

            Alert::toast('Data berhasil disimpan', 'success');
            return redirect()->route('admin.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $dataSekolah = Sekolah::all();
        return view('pages.admin.edit', compact('admin', 'dataSekolah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $admin->user_id,
            'password' => 'required',
            'sekolah_id' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->errors()->first(), 'error');
            return redirect()->back()->withInput();
        }

        try {
            $admin->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);

            $admin->update([
                'sekolah_id' => $request->sekolah_id,
            ]);

            Alert::toast('Data berhasil diupdate', 'success');
            return redirect()->route('admin.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        try {
            $admin->delete();
            $admin->user->delete();
            Alert::toast('Data berhasil dihapus', 'success');
            return redirect()->route('admin.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back();
        }
    }

    /**
     * Approve the specified resource from storage.
     */
    public function approve(Admin $admin)
    {
        try {
            $admin->update([
                'approved' => true,
            ]);
            Alert::toast('Data berhasil diapprove', 'success');
            return redirect()->route('admin.index');
        } catch (\Exception $e) {
            Alert::toast($e->getMessage(), 'error');
            return redirect()->back();
        }
    }
}