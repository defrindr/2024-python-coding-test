<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ManualBookController;
use App\Http\Controllers\SekolahCourse\GuruController;
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

Route::middleware(['auth', 'role:guru'])->group(function () {
    Route::get('/guru/dashboard', [DashboardController::class, 'guru'])->name('dashboard.guru');

    Route::get('/guru/course', [GuruController::class, 'index'])->name('guru.course.index');
    Route::get('/guru/course/{sekolahCourse}', [GuruController::class, 'show'])->name('guru.course.show');
    Route::get('/guru/course/{sekolahCourse}/edit', [GuruController::class, 'edit'])->name('guru.course.edit');
    Route::patch('/guru/course/{sekolahCourse}', [GuruController::class, 'update'])->name('guru.course.update');
    Route::put('/python-jawaban/{id}', [GuruController::class, 'updateKunciJawaban']);
    
});
