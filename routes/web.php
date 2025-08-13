<?php

use App\Http\Controllers\ComponentDetailsController;
use App\Http\Controllers\Components\CaseController;
use App\Http\Controllers\Components\CpuController;
use App\Http\Controllers\Components\GpuController;
use App\Http\Controllers\Components\MoboController;
use App\Http\Controllers\Components\PsuController;
use App\Http\Controllers\Components\RamController;
use App\Http\Controllers\Components\StorageController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserAccountController;
use App\Models\Hardware\Motherboard;
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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');


require __DIR__.'/auth.php';

// ADMIN ROUTES
Route::prefix('admin')->name('admin.')->group(function () {
    // DASHBOARD
    Route::get('dashboard', [UserAccountController::class, 'index'])->name('dashboard');

    // USER ACCOUNT
    Route::get('user-account', [UserAccountController::class, 'useraccount'])->name('useraccount');
    Route::post('dashboard', [UserAccountController::class, 'store'])->name('users.add');
    Route::post('users/{id}/approve', [UserAccountController::class, 'approve'])->name('users.approved');
    Route::delete('users/{id}/decline', [UserAccountController::class, 'decline'])->name('users.decline');
    Route::put('users/{id}/update', [UserAccountController::class, 'update']);
    Route::delete('users/{id}/delete', [UserAccountController::class, 'delete'])->name('users.delete');
});

// STAFF ROUTES
Route::prefix('staff')->name('staff.')->group(function () {
    //DASHBOARD
    Route::get('dashboard', [UserAccountController::class, 'index'])->name('dashboard');

    // COMPONENT DETAILS
    Route::get('component-details', [ComponentDetailsController::class, 'index'])->name('componentdetails');
    Route::post('component-details/motherboard', [MoboController::class, 'store'])->name('componentdetails.motherboard.store');
    Route::post('component-details/gpu', [GpuController::class, 'store'])->name('componentdetails.gpu.store');
    Route::post('component-details/case', [CaseController::class, 'store'])->name('componentdetails.case.store');
    Route::post('component-details/psu', [PsuController::class, 'store'])->name('componentdetails.psu.store');
    Route::post('component-details/ram', [RamController::class, 'store'])->name('componentdetails.ram.store');
    Route::post('component-details/storage', [StorageController::class, 'store'])->name('componentdetails.storage.store');
    Route::post('component-details/cpu', [CpuController::class, 'store'])->name('componentdetails.cpu.store');

});

// CUSTOMER ROUTES
Route::prefix('customer')->name('customer.')->group(function () {
    Route::get('customer/dashboard', [CustomerController::class, 'index'])->name('dashboard');
    Route::put('profile', [CustomerController::class, 'update'])->name('profile.update');
});

Route::resource('cpus', CpuController::class);
