<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\InternshipFlowController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminInternshipController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\PublicPageController; // ⬅️ TAMBAH INI

// ======= Public / User =======
Route::get('/', fn () => view('home'))->name('home');

// Halaman publik: Alumni selesai magang (8 / halaman)
Route::get('/interns/completed', [PublicPageController::class, 'completed'])
     ->name('interns.completed'); // ⬅️ TAMBAH INI

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [UserDashboardController::class, 'show'])->name('dashboard');

    // User Flow
    Route::post('/internship/letter', [InternshipFlowController::class, 'uploadLetter'])->name('internship.letter.upload');
    Route::post('/internship/profile', [InternshipFlowController::class, 'saveProfile'])->name('internship.profile.save');
    Route::post('/internship/final-report', [InternshipFlowController::class, 'uploadFinalReport'])->name('internship.final_report.upload');
});

// ======= Admin Area =======
Route::prefix('admin')->name('admin.')->group(function () {
    // login admin (guest only)
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login'])->middleware('throttle:5,1');
    });

    // protected admin
    Route::middleware(['auth','admin'])->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Users
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');

        // Pengajuan / Peserta
        Route::get('/internships', [AdminInternshipController::class, 'index'])->name('internships.index');
        Route::get('/internships/{internship}', [AdminInternshipController::class, 'show'])->name('internships.show');

        Route::post('/internships/{internship}/approve', [AdminInternshipController::class, 'approve'])->name('internships.approve');
        Route::post('/internships/{internship}/reject', [AdminInternshipController::class, 'reject'])->name('internships.reject')->middleware('throttle:5,1');

        // surat balasan & pesan
        Route::post('/internships/{internship}/approval-letter', [AdminInternshipController::class, 'uploadApprovalLetter'])->name('internships.approval_letter');
        Route::post('/internships/{internship}/message', [AdminInternshipController::class, 'sendMessage'])->name('internships.message');
    });
});
