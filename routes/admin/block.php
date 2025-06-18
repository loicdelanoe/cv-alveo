<?php

use App\Http\Controllers\BlockController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin/blocks')->group(function () {
    Route::group(['middleware' => ['can:create blocks']], function () {
        Route::post('/{blockType:type}', [BlockController::class, 'store'])->name('admin.block.store');
        Route::get('/{blockType:type}/create', [BlockController::class, 'create'])->name('admin.block.create');
    });

    Route::group(['middleware' => ['can:edit blocks']], function () {
        Route::patch('/{block}', [BlockController::class, 'update'])->name('admin.block.update');
    });

    Route::group(['middleware' => ['can:show blocks']], function () {
        Route::get('/', [BlockController::class, 'index'])->name('admin.block.index');
        Route::get('/{block}', [BlockController::class, 'show'])->name('admin.block.show');
    });

    Route::group(['middleware' => ['can:delete blocks']], function () {
        Route::delete('/{block}', [BlockController::class, 'destroy'])->name('admin.block.destroy');
    });

    Route::get('/fetch/{blockType:type}', [BlockController::class, 'getBlocksByType'])->name('admin.block.get-blocks-by-type');
});
