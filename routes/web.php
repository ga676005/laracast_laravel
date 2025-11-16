<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('/contact', 'contact')->name('contact');
Route::view('/about', 'about')->name('about');

Route::get('/locale/{locale}', [\App\Http\Controllers\LocaleController::class, 'switch'])->name('locale.switch');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    // Email Verification Routes (accessible without verification)
    Route::get('/email/verify', [RegisterController::class, 'showVerificationNotice'])->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', [RegisterController::class, 'verify'])
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [RegisterController::class, 'resend'])
        ->middleware('throttle:verification.resend')
        ->name('verification.send');
});

// Routes that require both authentication AND email verification
Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('jobs', JobController::class);
});
