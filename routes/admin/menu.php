<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin/menu')->group(function () {
    Route::group(['middleware' => ['can:create collections']], function () {
        Route::get('/create', [MenuController::class, 'create'])->name('admin.menu.create');
        Route::post('/', [MenuController::class, 'store'])->name('admin.menu.store');
    });

    Route::group(['middleware' => ['can:edit collections']], function () {
        Route::patch('/{menu:slug}', [MenuController::class, 'update'])->name('admin.menu.update');
    });

    Route::group(['middleware' => ['can:show collections']], function () {
        Route::get('/', [MenuController::class, 'index'])->name('admin.menu.index');
        Route::get('/{menu:slug}', [MenuController::class, 'show'])->name('admin.menu.show');
    });

    Route::group(['middleware' => ['can:delete collections']], function () {
        Route::delete('/{menu:slug}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');
    });
});
