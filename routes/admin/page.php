<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin/pages')->group(function () {
    Route::group(['middleware' => ['can:create pages']], function () {
        Route::get('/create', [PageController::class, 'create'])->name('admin.page.create');
        Route::post('/', [PageController::class, 'store'])->name('admin.page.store');
    });

    Route::group(['middleware' => ['can:edit pages']], function () {
        Route::patch('/settings', [PageController::class, 'updateSettings'])->name('admin.page.update-settings');
        Route::patch('/{page}', [PageController::class, 'update'])->name('admin.page.update');
    });

    Route::group(['middleware' => ['can:show pages']], function () {
        Route::get('/', [PageController::class, 'index'])->name('admin.page.index');
        Route::get('/settings', [PageController::class, 'settings'])->name('admin.page.settings');
        Route::get('/{page:slug}', [PageController::class, 'show'])->name('admin.page.show');
    });

    Route::group(['middleware' => ['can:delete pages']], function () {
        Route::delete('/{page:slug}', [PageController::class, 'destroy'])->name('admin.page.destroy');
    });
});
