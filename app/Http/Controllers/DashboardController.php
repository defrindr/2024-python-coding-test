<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function superAdmin()
    {
        $user = Auth::user();

        return view('pages.dashboard.super-admin-dashboard', compact('user'));
    }

    public function admin()
    {
        $user = Auth::user();
        $dataUser = Auth::user()->admin;

        return view('pages.dashboard.admin-dashboard', compact('user', 'dataUser'));
    }

    public function guru()
    {
        $user = Auth::user();
        $dataUser = Auth::user()->guru;

        return view('pages.dashboard.guru-dashboard', compact('user', 'dataUser'));
    }

    public function siswa()
    {
        $user = Auth::user();
        $dataUser = Auth::user()->siswa;

        return view('pages.dashboard.siswa-dashboard', compact('user', 'dataUser'));
    }
}