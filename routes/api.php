<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', fn () => ["msg" => "welcome to our system"]);

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'v1'
], function () {
    Route::apiResource('users', UserController::class);
});

// Route::middleware('auth:api')->get('/user', [AuthController::class, 'getMe']);

Route::post('/login', [AuthController::class, 'signIn']);
Route::post('/logout', [AuthController::class, 'signOut']);
