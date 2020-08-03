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
/*
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::get('/',function(){
    return view('welcome');
});
Route::prefix('auth')->group(function(){
    Route::get('init', 'AppController@init');
    Route::post('login', 'AppController@login');
    Route::post('register', 'AppController@register');
    Route::post('logout', 'AppController@logout');
    Route::post('setCookie', 'AppController@setCookie'); //獲得加密過後的username
    Route::post('getCookie', 'AppController@getCookie');
    Route::prefix('turnip')->group(function(){
        Route::get('getPrice', 'turnipController@index');
        Route::put('updatePrice', 'turnipController@store');
    });
});