<?php

use App\Http\Controllers\ViewController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Route::get('/', function () {
//     return Inertia::render('Welcome', [
//         'canLogin' => Route::has('login'),
//         'canRegister' => Route::has('register'),
//         'laravelVersion' => Application::VERSION,
//         'phpVersion' => PHP_VERSION,
//     ]);
// });

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';
require __DIR__.'/admin/block.php';
require __DIR__.'/admin/block-type.php';
require __DIR__.'/admin/page.php';
require __DIR__.'/admin/setting.php';
require __DIR__.'/admin/collection-type.php';
require __DIR__.'/admin/collection.php';
require __DIR__.'/admin.php';
require __DIR__.'/admin/api.php';
require __DIR__.'/admin/menu.php';
require __DIR__.'/admin/user.php';
require __DIR__.'/admin/media.php';
require __DIR__.'/admin/action.php';

Route::middleware('auth')->get('/dev', function () {
    return Inertia::render('Dev');
});

Route::get('/', [ViewController::class, 'index'])->name('page.index');
Route::get('/{slug}', [ViewController::class, 'page'])->name('page.show');
Route::get('/{collection}/{slug}', [ViewController::class, 'collection'])->name('page.collection');
