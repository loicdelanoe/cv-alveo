<?php

use App\Http\Controllers\CollectionTypeController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin/collection-types')->group(function () {
    Route::group(['middleware' => ['can:create collections']], function () {
        Route::get('/create', [CollectionTypeController::class, 'create'])->name('admin.collection-type.create');
        Route::post('/create', [CollectionTypeController::class, 'store'])->name('admin.collection-type.store');
    });

    Route::group(['middleware' => ['can:edit collections']], function () {});

    Route::group(['middleware' => ['can:show collections']], function () {
        Route::get('/', [CollectionTypeController::class, 'index'])->name('admin.collection-type.index');
        Route::get('/{collectionType:type}', [CollectionTypeController::class, 'show'])->name('admin.collection-type.show');
    });

    Route::group(['middleware' => ['can:delete collections']], function () {
        Route::delete('/{collectionType:type}', [CollectionTypeController::class, 'destroy'])->name('admin.collection-type.destroy');
    });
});
