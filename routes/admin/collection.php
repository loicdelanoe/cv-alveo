<?php

use App\Http\Controllers\CollectionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin/collections')->group(function () {
    Route::group(['middleware' => ['can:create collections']], function () {
        Route::get('/{collectionType:type}/create', [CollectionController::class, 'create'])->name('admin.collection.create');
        Route::post('/{collectionType:type}', [CollectionController::class, 'store'])->name('admin.collection.store');
    });

    Route::group(['middleware' => ['can:edit collections']], function () {
        Route::patch('/{collectionType:type}/{collection:slug}', [CollectionController::class, 'update'])->name('admin.collection.update');
    });

    Route::group(['middleware' => ['can:show collections']], function () {
        Route::get('/', [CollectionController::class, 'index'])->name('admin.collection.index');
        Route::get('/{collectionType:type}/{collection:slug}', [CollectionController::class, 'show'])->name('admin.collection.show');
    });

    Route::group(['middleware' => ['can:delete collections']], function () {
        Route::delete('/{collection:slug}', [CollectionController::class, 'destroy'])->name('admin.collection.destroy');
    });
});
