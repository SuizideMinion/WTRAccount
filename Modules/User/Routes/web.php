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

//Route::prefix('user')->group(function() {
//    Route::get('/', 'UserController@index');
//});

use Illuminate\Support\Facades\Route;

Route::resource('user', \Modules\User\Http\Controllers\UserController::class);
Route::resource('user/userdata', \Modules\User\Http\Controllers\UserDataController::class);
Route::resource('user/userpermission', \Modules\User\Http\Controllers\UserPermissionController::class);
