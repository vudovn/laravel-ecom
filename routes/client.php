<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\IndexController;

Route::get('/', [IndexController::class, 'home'])->name('home.index');
