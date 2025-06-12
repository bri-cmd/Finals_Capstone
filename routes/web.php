<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'login'])->name('login'); // -> name('login') serves as a route nickname used for links
Route::get('/users/register', [UserController::class, 'register'])->name('register');
Route::get('/users/forgot', [UserController::class, 'forgot'])->name('forgot');
Route::post('/users/login', [UserController::class, 'authenticated'])->name('authenticated');
Route::get('/dashboard/admin', [UserController::class, 'admin'])->name('admin');