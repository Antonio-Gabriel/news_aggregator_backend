<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
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
    Route::post('/articles', [ArticleController::class, 'store']);
    Route::put('/articles/{id}', [ArticleController::class, 'update']);

    // Filters
    Route::get('/articles/customs', [ArticleController::class, 'custom']);
});
