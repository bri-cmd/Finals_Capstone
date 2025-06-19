<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/users', [UserController::class, 'login'])->name('login'); // -> name('login') serves as a route nickname used for links
Route::get('/users/register', [UserController::class, 'register'])->name('register');
Route::get('/users/forgot', [UserController::class, 'forgot'])->name('forgot');
Route::post('/users/login', [UserController::class, 'authenticated'])->name('authenticated');
Route::get('/dashboard/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
Route::get('/dashboard/useraccount', [UserController::class, 'useraccount'])->name('useraccount');
Route::post('/dashboard', [UserController::class, 'store'])->name('store.adduser');
Route::post('/users/register', [UserController::class, 'registerUser'])->name('registeruser');
Route::post('/users/{id}', [UserController::class, 'approve'])->name('approvedUser');