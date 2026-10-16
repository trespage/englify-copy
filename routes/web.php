<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Superadmin\SuperAdminController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\MateriController;
use App\Http\Controllers\Siswa\SiswaController;

// =================================================================
// 1. LANDING PAGE
// =================================================================
Route::get('/', function () {
    return view('landing');
})->name('landing');


// =================================================================
// 2. AUTHENTICATION
// =================================================================
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.proses');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('change.password');
    Route::post('/update-password', [AuthController::class, 'updatePassword'])->name('update.password');
});


// =================================================================
// 3. SUPER ADMIN
// =================================================================
Route::middleware(['auth'])->prefix('superadmin')->name('superadmin.')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'index'])->name('dashboard');

    // Users (Fallback ke admin-divisi untuk mencegah error view not found)
    Route::get('/users', [SuperAdminController::class, 'users'])->name('users');
    Route::post('/users', [SuperAdminController::class, 'storeUser'])->name('users.store');
    Route::put('/users/{id}', [SuperAdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{id}', [SuperAdminController::class, 'destroyUser'])->name('users.destroy');

    // Kelola Akun Siswa
    Route::get('/siswa', [SuperAdminController::class, 'siswa'])->name('siswa');
    Route::post('/siswa', [SuperAdminController::class, 'storeSiswa'])->name('siswa.store');
    Route::put('/siswa/{id}', [SuperAdminController::class, 'updateSiswa'])->name('siswa.update');
    Route::delete('/siswa/{id}', [SuperAdminController::class, 'destroySiswa'])->name('siswa.destroy');

    // Kelola Admin Divisi
    Route::get('/admin-divisi', [SuperAdminController::class, 'adminDivisi'])->name('adminDivisi');
    Route::post('/admin-divisi', [SuperAdminController::class, 'storeAdminDivisi'])->name('adminDivisi.store');
    Route::put('/admin-divisi/{id}', [SuperAdminController::class, 'updateAdminDivisi'])->name('adminDivisi.update');
    Route::delete('/admin-divisi/{id}', [SuperAdminController::class, 'destroyAdminDivisi'])->name('adminDivisi.destroy');

    // Menu Lainnya
    Route::get('/divisi', [SuperAdminController::class, 'divisi'])->name('divisi');
    Route::get('/settings', [SuperAdminController::class, 'settings'])->name('settings');
    Route::get('/profile', [SuperAdminController::class, 'profile'])->name('profile');
});


// =================================================================
// 4. ADMIN DIVISI
// =================================================================
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

    // Kategori
    Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
    Route::put('/kategori/{id}', [KategoriController::class, 'update'])->name('kategori.update');
    Route::delete('/kategori/{id}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

    // Materi
    Route::get('/materi', [MateriController::class, 'index'])->name('materi');
    Route::post('/materi', [MateriController::class, 'store'])->name('materi.store');
    Route::put('/materi/{id}', [MateriController::class, 'update'])->name('materi.update');
    Route::delete('/materi/{id}', [MateriController::class, 'destroy'])->name('materi.destroy');

    // ==========================================
    // QUIZ MANAGEMENT (BARU)
    // ==========================================
    Route::get('/quiz', [AdminController::class, 'quiz'])->name('quiz');
    Route::post('/quiz', [AdminController::class, 'storeQuiz'])->name('quiz.store');
    Route::put('/quiz/{id}', [AdminController::class, 'updateQuiz'])->name('quiz.update');
    Route::delete('/quiz/{id}', [AdminController::class, 'destroyQuiz'])->name('quiz.destroy');

    // HASIL QUIZ (BARU)
    Route::get('/hasil-quiz', [AdminController::class, 'hasilQuiz'])->name('hasil-quiz');
    Route::get('/hasil-quiz/{id}', [AdminController::class, 'detailHasilQuiz'])->name('hasil-quiz.detail');
});


// =================================================================
// 5. SISWA
// =================================================================
Route::middleware(['auth'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaController::class, 'index'])->name('dashboard');
    Route::get('/materi/{id}', [SiswaController::class, 'baca'])->name('materi.baca');

    // (Opsional: Route untuk siswa mengerjakan quiz bisa ditambahkan di sini nanti)
    // Route::get('/quiz', [SiswaController::class, 'quizList'])->name('quiz');
    // Route::get('/quiz/{id}', [SiswaController::class, 'kerjakanQuiz'])->name('quiz.kerjakan');
    // Route::post('/quiz/{id}/submit', [SiswaController::class, 'submitQuiz'])->name('quiz.submit');
});
