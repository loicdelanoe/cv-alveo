<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin/users')->group(function () {
    Route::group(['middleware' => ['can:create users']], function () {
        Route::get('/create', [UserController::class, 'create'])->name('admin.user.create');
        Route::post('/', [UserController::class, 'store'])->name('admin.user.store');
    });

    Route::group(['middleware' => ['can:edit users']], function () {
        Route::patch('/{user}', [UserController::class, 'update'])->name('admin.user.update');
    });

    Route::group(['middleware' => ['can:show users']], function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.user.index');
        Route::get('/{user}', [UserController::class, 'show'])->name('admin.user.show');
    });

    Route::group(['middleware' => ['can:delete users']], function () {
        Route::delete('/{user}', [UserController::class, 'destroy'])->name('admin.user.destroy');
    });
});
