<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;

Route::get('/api/navigation', [ViewController::class, 'navigation'])->name('api.navigation');

Route::get('/api/media/{media}', [MediaController::class, 'getMedia'])->name('api.media');
Route::get('/api/pages', [PageController::class, 'getPages'])->name('api.pages');
