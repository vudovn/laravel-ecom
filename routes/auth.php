<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

Route::prefix('auth')->name('auth.')->middleware('checkLogin')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login.index');
    Route::post('/login', [AuthController::class, 'loginPost'])->name('login.post');

    Route::get('/register', [AuthController::class, 'register'])->name('register.index');
    Route::post('/register', [AuthController::class, 'registerPost'])->name('register.post');
});

Route::post('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

