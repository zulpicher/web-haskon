<?php

use App\Http\Controllers\BukuKasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    /*Company Dashboard*/
    Route::get('/dashboard', [HomeController::class, 'index'])
        ->name('dashboard');

    /*Modul Buku Kas*/
    Route::prefix('buku-kas')
        ->name('buku-kas.')
        ->group(function () {

            Route::get('/', [BukuKasController::class, 'index'])
                ->name('dashboard');
            Route::resource('transactions', TransactionController::class)
                ->only(['store', 'update', 'destroy']);
        });

    /*Profile*/
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
