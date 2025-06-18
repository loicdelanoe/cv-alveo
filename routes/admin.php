<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
