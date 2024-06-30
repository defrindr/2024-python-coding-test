<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManualBookController;
use App\Http\Controllers\PenilaianModulSiswaController;
use App\Http\Controllers\SekolahCourse\SiswaController;
use App\Models\PenilaianModulSiswa;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [DashboardController::class, 'siswa'])->name('dashboard.siswa');

    Route::get('/siswa/course', [SiswaController::class, 'index'])->name('siswa.course.index');
    Route::get('/siswa/course/{sekolahCourse}', [SiswaController::class, 'show'])->name('siswa.course.show');


    Route::post('/siswa/submit/{modulId}', [PenilaianModulSiswaController::class, 'submitJawaban'])->name('siswa.course.submit');
    Route::post('/siswa/save/{modulId}', [PenilaianModulSiswaController::class, 'saveJawaban'])->name('siswa.course.save');

});
