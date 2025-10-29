<?php
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;

Route::prefix('admin')->name('admin.')->middleware('checkAuth')->group(function () {
    // dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');

    // QL users
    Route::prefix('admin')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index'); // /admin/users

        Route::get('/create', [UserController::class, 'create'])->name('create.index');
        Route::post('/store', [UserController::class, 'store'])->name('store');

        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit.index');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('update');

        Route::post('/delete/{id}', [UserController::class, 'delete'])->name('delete');
    });
});

// API location
Route::get('/api/wards', [ApiController::class, 'getWards'])->name('get.wards');
