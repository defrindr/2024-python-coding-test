<?php

use App\Http\Controllers\KelasController;
use App\Http\Controllers\ModulController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PythonController;
use App\Http\Controllers\SekolahCourse\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\ManualBookController;
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

Route::get('/', function () {
    return view('pages.home');
});

Route::post('/kelas/get-by-sekolah', [KelasController::class, 'getKelas'])->name('kelas.getBySekolah');

Route::middleware('auth')->group(function () {
    Route::get('/download-modul/{modul}', [ModulController::class, 'downloadModul'])->name('modul.download');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/manualbook', [ManualBookController::class, 'index'])->name('manualbook.index');
    Route::get('/manualbook/download/{id}', [ManualBookController::class, 'download'])->name('manualbook.download');
});

Route::middleware(['auth', 'role:super_admin,admin,guru'])->group(function () {
    Route::prefix('/user/siswa')->group(function () {
        Route::get('/', [SiswaController::class, 'index'])->name('siswa.index');
        Route::get('/create', [SiswaController::class, 'create'])->name('siswa.create');
        Route::post('/', [SiswaController::class, 'store'])->name('siswa.store');
        Route::get('/{siswa}', [SiswaController::class, 'show'])->name('siswa.show');
        Route::get('/{siswa}/edit', [SiswaController::class, 'edit'])->name('siswa.edit');
        Route::patch('/{siswa}', [SiswaController::class, 'update'])->name('siswa.update');
        Route::delete('/{siswa}', [SiswaController::class, 'destroy'])->name('siswa.destroy');
        
    });
});

Route::middleware(['auth', 'role:admin,guru'])->group(function () {
    Route::get('/admin/kelas', [KelasController::class, 'index'])->name('admin.kelas.index');
    Route::get('/admin/kelas/create', [KelasController::class, 'create'])->name('admin.kelas.create');
    Route::post('/admin/kelas', [KelasController::class, 'store'])->name('admin.kelas.store');
    Route::get('/admin/kelas/{kelas}/edit', [KelasController::class, 'edit'])->name('admin.kelas.edit');
    Route::patch('/admin/kelas/{kelas}', [KelasController::class, 'update'])->name('admin.kelas.update');
    Route::delete('/admin/kelas/{kelas}', [KelasController::class, 'destroy'])->name('admin.kelas.destroy');

    Route::post('/modul', [ModulController::class, 'store'])->name('modul.store');
    Route::patch('/modul/{modul}', [ModulController::class, 'update'])->name('modul.update');
    Route::delete('/modul/{modul}', [ModulController::class, 'destroy'])->name('modul.destroy');

    
});

Route::get('/python-course-siswa/{id}', [PythonController::class, 'index']);
Route::get('/python-course/{id}', [GuruController::class, 'editKunciJawaban']);

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/manualbook/create', [ManualBookController::class, 'create'])->name('manualbook.create');
    Route::get('/manualbook', [ManualBookController::class, 'index'])->name('manualbook.index');
    Route::post('/manualbook/store', [ManualBookController::class, 'store'])->name('manualbook.store');
    
    Route::get('/manualbook/{manualBook}/edit', [ManualBookController::class, 'edit'])->name('manualbook.edit');
    Route::patch('/manualbook/{manualBook}', [ManualBookController::class, 'update'])->name('manualbook.update');
    Route::delete('/manualbook/{manualBook}', [ManualBookController::class, 'destroy'])->name('manualbook.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/super-admin.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/guru.php';
require __DIR__ . '/siswa.php';
