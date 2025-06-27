<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('dashboard/useraccount', [UserAccountController::class, 'useraccount'])->name('useraccount');
Route::post('dashboard', [UserAccountController::class, 'store'])->name('store.adduser');
Route::post('users/register', [UserAccountController::class, 'registerUser'])->name('registeruser');
Route::post('users/{id}/approve', [UserAccountController::class, 'approve'])->name('approvedUser');
Route::post('users/{id}/decline', [UserAccountController::class, 'decline'])->name('declineUser');