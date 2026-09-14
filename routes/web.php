<?php

use App\Http\Controllers\BukuKasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
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
            Route::get('/reports', [ReportController::class, 'index'])
                ->name('reports.index');
            Route::get('/reports/generate', [ReportController::class, 'generate'])
                ->name('reports.generate');
            Route::get('/reports/pdf', [ReportController::class, 'pdf'])
                ->name('reports.pdf');


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
