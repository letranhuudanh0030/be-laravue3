<?php

use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\ArticlesController;
use App\Http\Controllers\Api\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('articles', [ArticlesController::class, 'index']);
Route::get('articles/{article:slug}', [ArticlesController::class, 'show']);
Route::get('settings', [SettingsController::class, 'index']);
Route::post('contact-us', [ContactController::class, 'store']);
