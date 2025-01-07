<?php

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubKriteriaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group([
        'prefix' => 'kriteria',
    ], function() {
        Route::get('/', [KriteriaController::class, 'index'])->name('kriteria');
        Route::post('/simpan', [KriteriaController::class, 'store'])->name('kriteria.store');
        Route::get('/ubah', [KriteriaController::class, 'edit'])->name('kriteria.edit');
        Route::post('/ubah', [KriteriaController::class, 'update'])->name('kriteria.update');
        Route::post('/hapus', [KriteriaController::class, 'delete'])->name('kriteria.delete');
    });

    Route::group([
        'prefix' => 'sub-kriteria',
    ], function() {
        Route::get('/', [SubKriteriaController::class, 'index'])->name('sub-kriteria');
    });

    Route::group([
        'prefix' => 'alternatif',
    ], function() {
        Route::get('/', [AlternatifController::class, 'index'])->name('alternatif');
    });
});

require __DIR__.'/auth.php';
