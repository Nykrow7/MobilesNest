<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChangePasswordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Change Password Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/change-password', [ChangePasswordController::class, 'showChangePasswordForm'])->name('password.change-form');
    Route::post('/setup-security-question', [ChangePasswordController::class, 'setupSecurityQuestion'])->name('password.setup-security-question');
    Route::post('/validate-security-question', [ChangePasswordController::class, 'validateSecurityQuestion'])->name('password.validate-security-question');
    Route::post('/generate-otp', [ChangePasswordController::class, 'generateOTP'])->name('password.generate-otp');
    Route::post('/verify-otp', [ChangePasswordController::class, 'verifyOTP'])->name('password.verify-otp');
});

require __DIR__.'/auth.php';