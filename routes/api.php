<?php

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

Route::group(['prefix' => 'v1'], function () {
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::put('/categories/{id}', [CategoryController::class, 'update']);
});
