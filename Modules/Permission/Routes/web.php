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
    Route::resource('permission', \Modules\Permission\Http\Controllers\PermissionController::class);
});
//Route::prefix('permission')->group(function() {
//    Route::get('/', 'PermissionController@index');
//});
