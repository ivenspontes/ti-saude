<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login'])->name('jwt.auth.login');
    Route::post('logout', [AuthController::class, 'logout'])->name('jwt.auth.logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('jwt.auth.refresh');
    Route::post('me', [AuthController::class, 'me'])->name('jwt.auth.me');
});
