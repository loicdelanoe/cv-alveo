<?php

use App\Http\Controllers\MediaController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin/medias')->group(function () {
    Route::group(['middleware' => ['can:create medias']], function () {
        Route::post('/', [MediaController::class, 'store'])->name('admin.media.store');
    });

    Route::group(['middleware' => ['can:edit medias']], function () {
        Route::patch('/{media}', [MediaController::class, 'update'])->name('admin.media.update');
    });

    Route::group(['middleware' => ['can:show medias']], function () {
        Route::get('/', [MediaController::class, 'index'])->name('admin.media.index');
    });

    Route::group(['middleware' => ['can:delete medias']], function () {
        Route::delete('/{media}', [MediaController::class, 'destroy'])->name('admin.media.destroy');
    });
});
