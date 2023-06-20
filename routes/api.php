<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', fn () => ["msg" => "welcome to our system"]);

Route::group(['prefix' => 'v1'], function () {
    Route::apiResource('users', UserController::class);
});

Route::post('/login', [AuthController::class, 'signIn']);
Route::middleware('auth.protected')->post('/logout', [AuthController::class, 'signOut']);

Route::group([
    'prefix' => 'v1',
    'middleware' => 'auth.protected'
], function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
});

Route::group(['prefix' => 'v1'], function () {
    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('/articles/customs', [ArticleController::class, 'custom']);
    
    Route::get('/articles/{id}', [ArticleController::class, 'show']);
    
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::put('/articles/{id}', [ArticleController::class, 'update']);

    // Filters
});

Route::group([
    'prefix' => 'v1',
    'middleware' => 'auth.protected'
], function () {
    Route::post('/users/settings', [SettingsController::class, 'store']);
    Route::get('/users/settings/{userId}', [SettingsController::class, 'show']);
    Route::put('/users/settings/{id}', [SettingsController::class, 'update']);
});
