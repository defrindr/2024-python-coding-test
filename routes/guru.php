<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SekolahCourseGuruController;
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

    Route::get('/guru/course', [SekolahCourseGuruController::class, 'index'])->name('guru.course.index');
});