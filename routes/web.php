<?php

use App\Http\Controllers\CacheController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');

    // Cache management routes
    Route::prefix('cache')->name('cache.')->group(function () {
        Route::get('stats', [CacheController::class, 'stats'])->name('stats');
        Route::post('clear-all', [CacheController::class, 'clearAll'])->name('clear.all');
        Route::post('clear-pattern', [CacheController::class, 'clearByPattern'])->name('clear.pattern');
        Route::post('clear-products', [CacheController::class, 'clearProducts'])->name('clear.products');
        Route::post('clear-categories', [CacheController::class, 'clearCategories'])->name('clear.categories');
        Route::get('test', [CacheController::class, 'test'])->name('test');
        Route::post('warmup', [CacheController::class, 'warmup'])->name('warmup');
    });
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
