<?php

namespace App\Http\Controllers;

use App\Models\ManualBook;
use App\Models\Modul;
use App\Models\PenilaianModulSiswa;
use App\Models\Siswa;
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

        $model = \DB::select("select courses.name, sum(case when penilaian_modul_siswa.id is not null then 1 else 0 end) as peserta from courses 
            left join sekolah_course on sekolah_course.course_id=courses.id
            left join modul on modul.sekolah_course_id=sekolah_course.id
            left join penilaian_modul_siswa on penilaian_modul_siswa.modul_id=modul.id
            where sekolah_course.sekolah_id=?
            group by courses.id, courses.name", [$dataUser->sekolah_id]);

        $labels = [];
        $data = [];

        foreach ($model as $item) {
            // dd($item->peserta);
            $labels[] = $item->name;
            $data[] = $item->peserta;
        }


        return view('pages.dashboard.admin-dashboard', compact('user', 'dataUser', 'manualBooks', 'labels', 'data'));
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

        $model = \DB::select("select courses.name, sum(case when penilaian_modul_siswa.id is not null then 1 else 0 end) as peserta from courses 
            left join sekolah_course on sekolah_course.course_id=courses.id
            left join modul on modul.sekolah_course_id=sekolah_course.id
            left join penilaian_modul_siswa on penilaian_modul_siswa.modul_id=modul.id
            where sekolah_course.sekolah_id=?
            group by courses.id, courses.name", [$dataUser->sekolah_id]);
        $labels = [];
        $data = [];

        foreach ($model as $item) {
            // dd($item->peserta);
            $labels[] = $item->name;
            $data[] = $item->peserta;
        }

        return view('pages.dashboard.guru-dashboard', compact('user', 'dataUser', 'manualBooks', 'labels', 'data'));
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
