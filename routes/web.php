<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\CoordinatorController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    Route::middleware('role:technician')->group(function () {
        Route::get('/technician', [TechnicianController::class, 'index'])->name('technician.dashboard');
    });

    Route::middleware('role:coordinator')->group(function () {
        Route::get('/coordinator', [CoordinatorController::class, 'index'])->name('coordinator.dashboard');
    });
});

require __DIR__.'/auth.php';
