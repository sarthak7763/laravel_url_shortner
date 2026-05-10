<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShortUrlController;
use App\Http\Controllers\ShortUrlResolverController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('companies', CompanyController::class);
    Route::resource('users', UserController::class);
    Route::resource('short-urls', ShortUrlController::class);
});

// Public resolver route - must be last to avoid catching other routes
Route::get('{shortCode}', [ShortUrlResolverController::class, 'resolve'])
    ->where('shortCode', '[a-zA-Z0-9]{6}')
    ->name('short-url.resolve');

require __DIR__ . '/auth.php';
