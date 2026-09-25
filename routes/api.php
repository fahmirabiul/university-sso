<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;

Route::prefix('v1')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/user', function (Request $request) {
            return $request->user()->load('profile', 'roles');
        });

        // Client Management
        Route::get('/clients', [\App\Http\Controllers\Api\ClientController::class, 'index']);
        Route::post('/clients', [\App\Http\Controllers\Api\ClientController::class, 'store']);
        Route::delete('/clients/{client}', [\App\Http\Controllers\Api\ClientController::class, 'destroy']);
    });
});
