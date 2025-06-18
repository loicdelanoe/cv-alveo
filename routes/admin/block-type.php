<?php

use App\Http\Controllers\BlockTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin/block-types')->group(function () {
    Route::group(['middleware' => ['can:create blocks']], function () {
        Route::get('/create', [BlockTypeController::class, 'create'])->name('admin.block-type.create');
        Route::post('/', [BlockTypeController::class, 'store'])->name('admin.block-type.store');
    });

    Route::group(['middleware' => ['can:show blocks']], function () {
        Route::get('/', [BlockTypeController::class, 'index'])->name('admin.block-type.index');
        Route::get('/{blockType:type}', [BlockTypeController::class, 'show'])->name('admin.block-type.show');
    });

    Route::group(['middleware' => ['can:delete blocks']], function () {
        Route::delete('/{blockType:type}', [BlockTypeController::class, 'destroy'])->name('admin.block-type.destroy');
    });
});
