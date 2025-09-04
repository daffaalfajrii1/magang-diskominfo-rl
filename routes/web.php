<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\InternshipFlowController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| - Home (landing)
| - Auth manual (login, register, logout)
| - Dashboard user (butuh auth)
| - Step-1: Upload surat magang (PDF) -> status waiting_confirmation
|  Catatan: Step berikutnya (isi biodata, laporan, admin SB Admin) kita tambah nanti.
*/

// Home
Route::get('/', fn () => view('home'))->name('home');

// Auth (hanya untuk tamu/guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:5,1');
});

// Logout & Dashboard (butuh login)
Route::middleware('auth')->group(function () {
    // Dashboard user
    Route::get('/dashboard', [UserDashboardController::class, 'show'])->name('dashboard');

    // STEP 1: Upload surat magang (PDF)
    Route::post('/internship/letter', [InternshipFlowController::class, 'uploadLetter'])
        ->name('internship.letter.upload');
});
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');
// (Opsional) Fallback 404 ke home atau halaman khusus
// Route::fallback(fn () => redirect()->route('home'));
