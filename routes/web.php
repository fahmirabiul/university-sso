<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\AuthController;

use App\Http\Controllers\Web\Dashboard\DashboardController;
use App\Http\Controllers\Web\Clients\ClientController;
use App\Http\Controllers\Web\Users\UserController;
use App\Http\Controllers\Web\Roles\RoleController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
