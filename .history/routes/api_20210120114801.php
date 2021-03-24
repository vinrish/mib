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

Route::namespace('App\Http\Controllers\Api')->group(function() {

    Route::prefix('auth')->group(function() {

        Route::post('login', 'AuthController@login');
        Route::post('refresh-token', 'AuthController@refreshToken');
        Route::post('register', 'AuthController@signup');

    });

    Route::group([
        'middleware'=>'auth:api'
    ], function(){
        //user & logout
        Route::get('user', 'AuthController@index');
        Route::post('logout', 'AuthController@logout');

        //crud food
        Route::get('foods', 'FoodController@index');
        Route::post('foods/create', 'FoodController@create');
        Route::post('foods/delete', 'FoodController@delete');
        Route::post('foods/update', 'FoodController@update');

    });


});
