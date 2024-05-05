<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SekolahCourseController;
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

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('dashboard.admin');

    Route::get('admin/guru', [GuruController::class, 'index'])->name('admin.guru.index');
    Route::get('admin/guru/create', [GuruController::class, 'create'])->name('admin.guru.create');
    Route::post('admin/guru', [GuruController::class, 'store'])->name('admin.guru.store');
    Route::get('admin/guru/{guru}/edit', [GuruController::class, 'edit'])->name('admin.guru.edit');
    Route::patch('admin/guru/{guru}', [GuruController::class, 'update'])->name('admin.guru.update');
    Route::delete('admin/guru/{guru}', [GuruController::class, 'destroy'])->name('admin.guru.destroy');

    Route::get('/admin/course', [SekolahCourseController::class, 'index'])->name('admin.course.index');
    Route::get('/admin/course/create', [SekolahCourseController::class, 'create'])->name('admin.course.create');
    Route::post('/admin/course', [SekolahCourseController::class, 'store'])->name('admin.course.store');
    Route::get('/admin/course/{sekolahCourse}/edit', [SekolahCourseController::class, 'edit'])->name('admin.course.edit');
    Route::patch('/admin/course/{sekolahCourse}', [SekolahCourseController::class, 'update'])->name('admin.course.update');
    Route::delete('/admin/course/{sekolahCourse}', [SekolahCourseController::class, 'destroy'])->name('admin.course.destroy');

    Route::patch('/admin/profile/sekolah', [ProfileController::class, 'updateSekolah'])->name('profile.updateSekolah');
});