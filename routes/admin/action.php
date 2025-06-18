<?php

use App\Http\Controllers\ActionController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('admin/actions')->group(function () {
    Route::post('/', [ActionController::class, 'store'])->name('admin.action.store');

    Route::delete('/{action}', [ActionController::class, 'destroy'])->name('admin.action.destroy');
});
