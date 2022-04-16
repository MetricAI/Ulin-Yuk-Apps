<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;
use Modules\LogStatistic\Http\Controllers\LogStatisticController;

Route::prefix('logstatistic')->group(function() {
    Route::get('/', [LogStatisticController::class, 'index']);
    Route::post('/store', [LogStatisticController::class, 'store']);
    Route::get('/getdata/{id}', [LogStatisticController::class, 'getdata']);
    Route::get('/show/{id}', [LogStatisticController::class, 'show']);
    Route::get('/getdatayajra', [LogStatisticController::class, 'getdatayajra']);
    Route::post('/update/{id}', [LogStatisticController::class, 'update']);
    Route::get('/delete/{id}', [LogStatisticController::class, 'destroy']);
});
