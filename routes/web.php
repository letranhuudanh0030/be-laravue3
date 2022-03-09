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

Route::get('/sales', function(){
    $report = new Acme\SingleResponsibility\Reporting\SalesReporter(new Acme\SingleResponsibility\Repositories\SalesRepository);

    $begin = Carbon\Carbon::now()->subDays(10);
    $end = Carbon\Carbon::now();

    return $report->between($begin, $end, new Acme\SingleResponsibility\Reporting\HtmlOutput);
});

Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::controller(SettingsController::class)->prefix('settings')->group(function () {
            Route::get('/', 'create')->name('settings.create');
            Route::post('save-hero', 'saveHero')->name('settings.save-hero');
            Route::post('save-about', 'saveAbout')->name('settings.save-about');
            Route::post('save-contact', 'saveContact')->name('settings.save-contact');
        });

        Route::controller(CategoriesController::class)->prefix('categories')->group(function () {
            Route::get('index-recursive', 'indexRecursive')->name('categories.index.recursive');
            Route::get('create-recursive/{category?}', 'createRecursive')->name('categories.create.recursive');
        });

        Route::controller(ArticlesController::class)->prefix('articles')->group(function () {
            Route::get('show-article-by-category/{category}', 'showArticleByCategory')->name('articles.show-by-category');
            Route::get('create-article-by-category/{category}', 'createArticleByCategory')->name('articles.create-by-category');
            Route::get('search', 'search')->name('articles.search');
        });

        Route::resources([
            'categories' => CategoriesController::class,
            'articles' => ArticlesController::class
        ]);
    });
