<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::prefix('admin')->name('admin.')->middleware('checkAuth')->group(function () {
    // dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    // QL users
    Route::get('/users', function () {
        echo route('admin.users.index'); // http://127.0.0.1:8000/admin/users
    })->name('users.index'); // /admin/users
    // name = admin.users.index
});
