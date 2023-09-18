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

Route::middleware('auth')->group(function () {
    Route::resource('timemanagment/request', \Modules\TimeManagment\Http\Controllers\RequestTimeChanceController::class);
    Route::resource('timemanagment/statistik', \Modules\TimeManagment\Http\Controllers\StatistikController::class);
    Route::resource('timemanagment', \Modules\TimeManagment\Http\Controllers\TimeManagmentController::class);
});
//Route::prefix('timemanagment')->group(function() {
//    Route::get('/', 'TimeManagmentController@index');
//});
