<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/latest', \App\Http\Controllers\LatestController::class)
    ->only('index');

Route::get('/history/', [\App\Http\Controllers\HistoryController::class, 'index']);
Route::get('/history/{date}', [\App\Http\Controllers\HistoryController::class, 'show']);
