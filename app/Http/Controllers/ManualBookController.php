<?php

namespace App\Http\Controllers;

use App\Models\ManualBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Spatie\Permission\Models\Role;

class ManualBookController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'role:super_admin'])->only(['create', 'store', 'edit', 'update', 'destroy']);
        // $this->middleware('auth')->only(['index', 'download']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        $manualBooks = ManualBook::all(); // Menambahkan pengambilan data ManualBook
        
        return view('pages.manualbook.index', compact('roles', 'manualBooks'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.manualbook.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:8192',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('/manual_books', $fileName);

        ManualBook::create([
            'nama' => $fileName,
            'file_path' => $filePath,
            'role_id' => $request->role_id,
        ]);

        Alert::success('Success', 'Manual book uploaded successfully');
        return redirect()->route('manualbook.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ManualBook $manualBook)
    {
        return view('pages.manualbook.edit', compact('manualBook'));
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

            $manualBook = ManualBook::find($id);
            if ($request->hasFile('file')) {
                if ($manualBook->file_path) {
                    Storage::delete($manualBook->file_path);
                }

                $file = $request->file('file');
                $file_name = date('d-m-Y') . '_' . $file->getClientOriginalName();
                $file_path = $file->storeAs('public/manualbook', $file_name);
                $manualBook->file_path = $file_path;
                $manualBook->nama = $file_name;
            }

            $manualBook->save();
            Alert::success('Success', 'Manual Book berhasil diperbarui');
            return redirect()->route('manualbook.index');
        } catch (\Exception $e) {
            Alert::error('Error', $e->getMessage());
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $manualBook = ManualBook::findOrFail($id);
        Storage::delete($manualBook->file_path);
        $manualBook->delete();

        return redirect()->back()->with('success', 'Manual Book deleted successfully.');
    }

    public function download($id)
    {
        // $manualBooks = ManualBook::find($id);
        $manualBooks = ManualBook::where('id', $id)->first();
        if ($manualBooks) {
            // return Storage::download('storage/'. $manualBooks->file_path, $manualBooks->nama);
            //  public_path('storage/' . $manualBooks->file_path);
            // create download 
            return response()->download(public_path('storage/' . $manualBooks->file_path), $manualBooks->nama);
        }

        return redirect()->back()->with('error', 'Manual Book not found.');
    }
}
