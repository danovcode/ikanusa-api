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

Route::post('v1/ikanusa/registration', 'App\Http\Controllers\UserController@register');
Route::post('v1/ikanusa/login', 'App\Http\Controllers\UserController@login');
Route::get('v1/ikanusa/user', 'App\Http\Controllers\UserController@getAuthenticatedUser')->middleware('jwt.verify');
Route::get('refresh-token', 'App\Http\Controllers\UserController@refreshToken');

Route::post('v1/ikanusa/toko/create', 'App\Http\Controllers\TokoController@createToko')->middleware('jwt.verify');
Route::get('v1/ikanusa/toko/me', 'App\Http\Controllers\TokoController@getMyToko')->middleware('jwt.verify');
Route::get('v1/ikanusa/toko/get/{id}', 'App\Http\Controllers\TokoController@getToko')->middleware('jwt.verify');

Route::post('v1/ikanusa/production/create', 'App\Http\Controllers\ProductController@createProduct')->middleware('jwt.verify');
Route::get('v1/ikanusa/production/all/jual', 'App\Http\Controllers\ProductController@showAllJual')->middleware('jwt.verify');
Route::get('v1/ikanusa/production/all/beli', 'App\Http\Controllers\ProductController@showAllBeli')->middleware('jwt.verify');
Route::get('v1/ikanusa/production/get/{id}', 'App\Http\Controllers\ProductController@showdetail')->middleware('jwt.verify');
Route::get('v1/ikanusa/production/pesananbaru', 'App\Http\Controllers\ProductController@pesananBaru')->middleware('jwt.verify');
Route::get('v1/ikanusa/production/pembelianBaru', 'App\Http\Controllers\ProductController@pembelianBaru')->middleware('jwt.verify');
Route::post('v1/ikanusa/production/accept/{id}', 'App\Http\Controllers\ProductController@accept')->middleware('jwt.verify');
Route::post('v1/ikanusa/production/reject/{id}', 'App\Http\Controllers\ProductController@reject')->middleware('jwt.verify');


Route::post('v1/ikanusa/image', 'App\Http\Controllers\MultipleUploadController@upload')->middleware('jwt.verify');

