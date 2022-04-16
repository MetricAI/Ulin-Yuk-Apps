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
use Modules\MenuSetting\Http\Controllers\MenuSettingController;

Route::prefix('menu-setting')->group(function() {
    Route::get('/', [MenuSettingController::class, 'index']);
    Route::get('/create', [MenuSettingController::class, 'create']);
    Route::get('/edit/{id}', [MenuSettingController::class, 'edit']);
    Route::post('/store', [MenuSettingController::class, 'store']);
    Route::post('/update/{id}', [MenuSettingController::class, 'update']);
    Route::get('/delete/{id}', [MenuSettingController::class, 'destroy']);
    Route::get('/getdata/{id}', [MenuSettingController::class, 'getdata']);
});
