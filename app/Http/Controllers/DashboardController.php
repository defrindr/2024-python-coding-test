<?php

namespace App\Http\Controllers;

use App\Models\ManualBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function superAdmin()
    {
        $user = Auth::user();
        $manualBooks = ManualBook::
        select('manual_books.*', 'roles.name as role_name')
        ->join('roles', 'manual_books.role_id', '=', 'roles.id')
        ->where('roles.name', 'super_admin')
        ->get();
        
        return view('pages.dashboard.super-admin-dashboard', compact('user', 'manualBooks'));
    }

    public function admin()
    {
        $user = Auth::user();
        $dataUser = Auth::user()->admin;
        $manualBooks = ManualBook::
        select('manual_books.*', 'roles.name as role_name')
        ->join('roles', 'manual_books.role_id', '=', 'roles.id')
        ->where('roles.name', 'admin')
        ->get();
        
        
        return view('pages.dashboard.admin-dashboard', compact('user', 'dataUser', 'manualBooks'));
    }

    public function guru()
    {
        $user = Auth::user();
        $dataUser = Auth::user()->guru;
        $manualBooks = ManualBook::
        select('manual_books.*', 'roles.name as role_name')
        ->join('roles', 'manual_books.role_id', '=', 'roles.id')
        ->where('roles.name', 'guru')
        ->get();
        

        return view('pages.dashboard.guru-dashboard', compact('user', 'dataUser', 'manualBooks'));
    }

    public function siswa()
    {
        $user = Auth::user();
        $dataUser = Auth::user()->siswa;
        $manualBooks = ManualBook::
        select('manual_books.*', 'roles.name as role_name')
        ->join('roles', 'manual_books.role_id', '=', 'roles.id')
        ->where('roles.name', 'siswa')
        ->get();
    
        return view('pages.dashboard.siswa-dashboard', compact('user', 'dataUser', 'manualBooks'));
    }
}
