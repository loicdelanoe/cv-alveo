<?php

use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->get('/admin/settings', [SettingController::class, 'index'])->name('admin.setting.index');
