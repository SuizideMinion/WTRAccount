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

Route::resource('orders', \Modules\Orders\Http\Controllers\OrdersController::class)->middleware(['auth', 'verified']);

Route::post('order/updaterequest','Modules\Orders\Http\Controllers\APIOrdersController@update');
Route::get('order/getdata','Modules\Orders\Http\Controllers\APIOrdersController@index');
