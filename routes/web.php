<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\CategoriesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])
    ->prefix('dashboard')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('settings', [SettingsController::class, 'create'])->name('settings.create');
        Route::post('settings/save-hero', [SettingsController::class, 'saveHero'])->name('settings.save-hero');
        Route::post('settings/save-about', [SettingsController::class, 'saveAbout'])->name('settings.save-about');
        Route::post('settings/save-contact', [SettingsController::class, 'saveContact'])->name('settings.save-contact');
        Route::get('categories/index-recursive', [CategoriesController::class, 'indexRecursive'])->name('categories.index.recursive');
        Route::get('categories/create-recursive/{category?}', [CategoriesController::class, 'createRecursive'])->name('categories.create.recursive');
        Route::resource('categories', CategoriesController::class);
        Route::resource('articles', ArticlesController::class);
    });
