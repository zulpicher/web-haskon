<?php

use App\Http\Controllers\BukuKasController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskCommentController;
use App\Http\Controllers\Admin\GroupController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('groups', GroupController::class)
            ->except(['show']);

        Route::post(
            'groups/{group}/members',
            [GroupController::class, 'addMember']
        )->name('groups.members.add');

        Route::delete(
            'groups/{group}/members/{user}',
            [GroupController::class, 'removeMember']
        )->name('groups.members.remove');
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
            Route::get('/reports/excel', [ReportController::class, 'excel'])
                ->name('reports.excel');


        });

    /*Profile*/
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*Modul task manajement*/    
    Route::resource('tasks', TaskController::class);
    Route::post(
        'tasks/{task}/comments',
        [TaskCommentController::class, 'store']
    )->name('tasks.comments.store');
    Route::get(
        'task-comments/{comment}/attachment',
        [TaskCommentController::class, 'attachment']
    )->name('tasks.comments.attachment');
    Route::delete(
        'task-comments/{comment}',
        [TaskCommentController::class, 'destroy']
    )->name('tasks.comments.destroy');

});

require __DIR__.'/auth.php';

Route::get('/test-speed', function () {
    return 'Laravel OK';
});
