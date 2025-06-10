<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'login'])->name('login'); // -> name('login') serves as a route nickname used for links
Route::get('/users/register', [UserController::class, 'register'])->name('register');