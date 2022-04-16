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
use Modules\LogActivity\Http\Controllers\LogActivityController;

Route::prefix('logactivity')->group(function () {
    Route::get('/', [LogActivityController::class, 'index']);
    Route::post('/store', [LogActivityController::class, 'store']);
    Route::get('/getdata/{id}', [LogActivityController::class, 'getdata']);
    Route::get('/show/{id}', [LogActivityController::class, 'show']);
    Route::get('/getdatayajra', [LogActivityController::class, 'getdatayajra']);
    Route::post('/update/{id}', [LogActivityController::class, 'update']);
    Route::get('/delete/{id}', [LogActivityController::class, 'destroy']);
});
