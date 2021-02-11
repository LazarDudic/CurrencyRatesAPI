<?php

use Illuminate\Support\Facades\Route;


Route::post('/register', [\App\Http\Controllers\Auth\AuthController::class, 'register'])->name('register');
Route::post('/login', [\App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/latest', [\App\Http\Controllers\LatestController::class, 'index']);
    Route::get('/history/', [\App\Http\Controllers\HistoryController::class, 'index']);
    Route::get('/history/{date}', [\App\Http\Controllers\HistoryController::class, 'show']);
});

