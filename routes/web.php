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
    ->prefix('admin')
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        Route::controller(SettingsController::class)->group(function () {
            Route::get('settings', 'create')->name('settings.create');
            Route::post('settings/save-hero','saveHero')->name('settings.save-hero');
            Route::post('settings/save-about','saveAbout')->name('settings.save-about');
            Route::post('settings/save-contact','saveContact')->name('settings.save-contact');
        });

        Route::controller(CategoriesController::class)->group(function () {
            Route::get('categories/index-recursive', 'indexRecursive')->name('categories.index.recursive');
            Route::get('categories/create-recursive/{category?}','createRecursive')->name('categories.create.recursive');
        });

        Route::controller(ArticlesController::class)->group(function () {
            Route::get('show-article-by-category/{category}','showArticleByCategory')->name('articles.show-by-category');
            Route::get('create-article-by-category/{category}','createArticleByCategory')->name('articles.create-by-category');
        });

        Route::resources([
            'categories' => CategoriesController::class,
            'articles' => ArticlesController::class
        ]);
    });
