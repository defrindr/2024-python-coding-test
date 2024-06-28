<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\ManualBookController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SekolahController;
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

Route::middleware(['auth', 'role:super_admin'])->group(function () {
    Route::get('/super-admin/dashboard', [DashboardController::class, 'superAdmin'])->name('dashboard.super-admin');

    Route::prefix('sekolah')->group(function () {
        Route::get('/', [SekolahController::class, 'index'])->name('sekolah.index');
        Route::get('/create', [SekolahController::class, 'create'])->name('sekolah.create');
        Route::post('/', [SekolahController::class, 'store'])->name('sekolah.store');
        Route::get('/{sekolah}', [SekolahController::class, 'show'])->name('sekolah.show');
        Route::get('/{sekolah}/edit', [SekolahController::class, 'edit'])->name('sekolah.edit');
        Route::patch('/{sekolah}', [SekolahController::class, 'update'])->name('sekolah.update');
        Route::delete('/{sekolah}', [SekolahController::class, 'destroy'])->name('sekolah.destroy');
    });

    Route::prefix('kelas')->group(function () {
        Route::get('/', [KelasController::class, 'index'])->name('kelas.index');
        Route::get('/create', [KelasController::class, 'create'])->name('kelas.create');
        Route::post('/', [KelasController::class, 'store'])->name('kelas.store');
        Route::get('/{kelas}', [KelasController::class, 'show'])->name('kelas.show');
        Route::get('/{kelas}/edit', [KelasController::class, 'edit'])->name('kelas.edit');
        Route::patch('/{kelas}', [KelasController::class, 'update'])->name('kelas.update');
        Route::delete('/{kelas}', [KelasController::class, 'destroy'])->name('kelas.destroy');
    });

    Route::prefix('user/admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.index');
        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/{admin}', [AdminController::class, 'show'])->name('admin.show');
        Route::get('/{admin}/edit', [AdminController::class, 'edit'])->name('admin.edit');
        Route::patch('/{admin}', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/{admin}', [AdminController::class, 'destroy'])->name('admin.destroy');
        Route::get('/{admin}/approve', [AdminController::class, 'approve'])->name('admin.approve');
    });

    Route::prefix('user/guru')->group(function () {
        Route::get('/', [GuruController::class, 'index'])->name('guru.index');
        Route::get('/create', [GuruController::class, 'create'])->name('guru.create');
        Route::post('/', [GuruController::class, 'store'])->name('guru.store');
        Route::get('/{guru}', [GuruController::class, 'show'])->name('guru.show');
        Route::get('/{guru}/edit', [GuruController::class, 'edit'])->name('guru.edit');
        Route::patch('/{guru}', [GuruController::class, 'update'])->name('guru.update');
        Route::delete('/{guru}', [GuruController::class, 'destroy'])->name('guru.destroy');
    });

    Route::prefix('course')->group(function () {
        Route::get('/', [CourseController::class, 'index'])->name('course.index');
        Route::get('/create', [CourseController::class, 'create'])->name('course.create');
        Route::post('/', [CourseController::class, 'store'])->name('course.store');
        Route::get('/{course}', [CourseController::class, 'show'])->name('course.show');
        Route::get('/{course}/edit', [CourseController::class, 'edit'])->name('course.edit');
        Route::patch('/{course}', [CourseController::class, 'update'])->name('course.update');
        Route::delete('/{course}', [CourseController::class, 'destroy'])->name('course.destroy');
    });

    Route::prefix('permission')->group(function () {
        Route::get('/', [RolePermissionController::class, 'index'])->name('permission.index');
        Route::get('/{role}/edit', [RolePermissionController::class, 'edit'])->name('permission.edit');
        Route::put('/{role}', [RolePermissionController::class, 'update'])->name('permission.update');
    });

    Route::prefix('manualbook')->group(function () {
        Route::get('/', [ManualBookController::class, 'index'])->name('manualbook.index');
        Route::get('/create', [ManualBookController::class, 'create'])->name('manualbook.create');
        // Route::post('/', [ManualBookController::class, 'store'])->name('manualbook.store');
        Route::get('/{manualBook}/edit', [ManualBookController::class, 'edit'])->name('manualbook.edit');
        Route::patch('/{manualBook}', [ManualBookController::class, 'update'])->name('manualbook.update');
        Route::delete('/{manualBook}', [ManualBookController::class, 'destroy'])->name('manualbook.destroy');
        
    });
});
