<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CropController;
use App\Http\Controllers\VarietyController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\CropPlantingController;

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

Route::get('/varieties', [VarietyController::class, 'getByCategory']);

Route::get('/crops/by-category', [CropController::class, 'getByCategory']);

Route::middleware(['auth'])->group(function () {
    Route::resource('farmers', FarmerController::class)->except(['show']);
});

Route::middleware(['auth'])->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    });

    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
    });

    Route::middleware('role:technician')->group(function () {
        Route::get('/technician', [TechnicianController::class, 'index'])->name('technician.dashboard');
    });

    Route::middleware('role:coordinator')->group(function () {
        Route::get('/coordinator', [CoordinatorController::class, 'index'])->name('coordinator.dashboard');
    });
});

Route::middleware(['auth'])->group(function () {
    Route::get('/crops', [CropController::class, 'index'])->name('crops.index');

    Route::middleware(['can:create-crops'])->group(function () {
        Route::get('/crops/create', [CropController::class, 'create'])->name('crops.create');
        Route::post('/crops', [CropController::class, 'store'])->name('crops.store');
    });

    Route::middleware(['can:update-crops'])->group(function () {
        Route::get('/crops/{crop}/edit', [CropController::class, 'edit'])->name('crops.edit');
        Route::put('/crops/{crop}', [CropController::class, 'update'])->name('crops.update');
    });

    Route::middleware(['can:delete-crops'])->group(function () {
        Route::delete('/crops/{crop}', [CropController::class, 'destroy'])->name('crops.destroy');
    });
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('/associations', [AssociationController::class, 'index'])
        ->middleware('can:view associations')
        ->name('associations.index');

    Route::get('/associations/create', [AssociationController::class, 'create'])
        ->middleware('can:create associations')
        ->name('associations.create');

    Route::post('/associations', [AssociationController::class, 'store'])
        ->middleware('can:create associations')
        ->name('associations.store');

    Route::get('/associations/{association}/edit', [AssociationController::class, 'edit'])
        ->middleware('can:update associations')
        ->name('associations.edit');

    Route::put('/associations/{association}', [AssociationController::class, 'update'])
        ->middleware('can:update associations')
        ->name('associations.update');

    Route::delete('/associations/{association}', [AssociationController::class, 'destroy'])
        ->middleware('can:delete associations')
        ->name('associations.destroy');

    Route::middleware('permission:view crop planting')->group(function() {
        Route::get('/crop_plantings', [CropPlantingController::class, 'index'])->name('crop_plantings.index');

        Route::middleware('permission:manage crop planting')->group(function() {
            Route::get('/crop_plantings/create', [CropPlantingController::class, 'create'])->name('crop_plantings.create');
            Route::post('/crop_plantings', [CropPlantingController::class, 'store'])->name('crop_plantings.store');
            Route::get('/crop_plantings/{cropPlanting}/edit', [CropPlantingController::class, 'edit'])->name('crop_plantings.edit');
            Route::put('/crop_plantings/{cropPlanting}', [CropPlantingController::class, 'update'])->name('crop_plantings.update');
            Route::delete('/crop_plantings/{cropPlanting}', [CropPlantingController::class, 'destroy'])->name('crop_plantings.destroy');
        });
    });
});

require __DIR__.'/auth.php';
