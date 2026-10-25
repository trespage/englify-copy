<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\KategoriController;
use App\Http\Controllers\admin\MateriController;
use App\Http\Controllers\admin\QuizController;
use App\Http\Controllers\admin\MonitoringController;
use App\Http\Controllers\siswa\SiswaController;
use App\Http\Controllers\superadmin\SuperAdminController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Semua endpoint memakai prefix /api otomatis dari bootstrap/app.php
| Contoh: GET /api/kategori, GET /api/materi, dst.
|--------------------------------------------------------------------------
*/

// Data publik (tanpa login) — untuk keperluan integrasi eksternal
Route::get('/kategori', [KategoriController::class, 'apiIndex'])->name('api.kategori');
Route::get('/materi', [MateriController::class, 'apiIndex'])->name('api.materi');
Route::get('/quiz', [QuizController::class, 'apiIndex'])->name('api.quiz');
Route::get('/monitoring', [MonitoringController::class, 'apiIndex'])->name('api.monitoring');
Route::get('/users', [SuperAdminController::class, 'apiUsers'])->name('api.users');

// Progress siswa — butuh sesi login (pakai guard web via cookie)
Route::get('/siswa/progress', [SiswaController::class, 'apiProgress'])
    ->middleware(['web', 'auth'])
    ->name('api.siswa.progress');
