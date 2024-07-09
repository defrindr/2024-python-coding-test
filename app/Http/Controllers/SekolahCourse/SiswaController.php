<?php

namespace App\Http\Controllers\SekolahCourse;

use App\Http\Controllers\Controller;
use App\Models\PenilaianModulSiswa;
use App\Models\SekolahCourse;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = SekolahCourse::with('sekolah', 'course', 'guru.user')->where('sekolah_id', Auth::user()->siswa->sekolah_id)->latest()->get();
        if ($request->ajax()) {
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('pages.siswa_course.actions', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('pages.siswa_course.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(SekolahCourse $sekolahCourse)
    {
        try {
            if (Auth::user()->siswa->sekolah_id !== $sekolahCourse->sekolah_id) {
                Alert::error('Error', 'Anda tidak memiliki akses ke course ini');
                return redirect()->route('guru.course.index');
            }

            $data = $sekolahCourse->modul->load('sekolahCourse.course');
            if (request()->ajax()) {
                $querySudahDikerjakan = PenilaianModulSiswa::where('siswa_id', Auth::user()->siswa->id)->where('is_upload_tugas', 1)->select('modul_id');
                $firstNext = $sekolahCourse->modul()->whereNotIn(
                    'id',
                    $querySudahDikerjakan
                )->first();
                $data = $sekolahCourse->modul()->whereIn(
                    'id',
                    $querySudahDikerjakan
                );

                if ($firstNext) {
                    $data->orWhere('id', $firstNext->id);
                }
                return datatables()->of($data->get())
                    ->addIndexColumn()
                    ->addColumn('action', function ($row) {
                        $sudahMengerjakan = PenilaianModulSiswa::where('siswa_id', Auth::user()->siswa->id)
                            ->where('modul_id', $row->id)->first();
                        return view('pages.siswa_course.modul.actions', compact('row', 'sudahMengerjakan'));
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            if ($sekolahCourse->modul()->count() == 0) {
                Alert::toast('Modul belum siap', 'warning');
            }

            // $penilaianModulSiswa = PenilaianModulSiswa::where('siswa_id', Auth::user()->siswa->id);
            // $nilaiUpload = $penilaianModulSiswa->select('point')->toArray();
            $modelLabels = $sekolahCourse->modul()->select('id', 'nama')->get();
            $labels = [];
            $dataset = [];
            foreach ($modelLabels as $index => $label) {
                $total = 0;
                $data = PenilaianModulSiswa::where('siswa_id', Auth::user()->siswa->id)->where('modul_id', $label->id)->select('point')->first();
                if ($data) {
                    $total = $data->point ?? 0;
                }

                $labels[] = $label->nama;
                $dataset[] = [
                    'name' => $label->nama,
                    'data' => $total
                ];
            }
            // die;

            $chart = (new LarapexChart)->lineChart()->setTitle('Penilaian Modul Siswa')
                ->setDataset([
                    [
                        'name' => 'Progress Modul',
                        'data' => array_column($dataset, 'data')
                    ]

                ])
                ->setLabels($labels)
                ->setColors(['#2C50EF'])
                ->setMarkers()
                ->setHeight(400)
                ->setWidth(1152);

            return view('pages.siswa_course.show', compact('sekolahCourse', 'chart'));
        } catch (\Throwable $th) {
            Alert::error('Error', $th->getMessage());
            return redirect()->back()->withInput();
        }
    }
}