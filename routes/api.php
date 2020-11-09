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
Route::get( 'echo', 'TestController@echo');

Route::get( 'echo2', 'TestController@echo2');

Route::prefix( 'v1')->namespace( 'api')->group( function () {

    Route::get( 'echo', 'TestController@echo');

    Route::post( 'auth', 'LoginController@auth');
    Route::post( 'users', 'UserController@store');

    Route::group( ['middleware' => [ 'jwt']], function(){
        Route::get( 'echoAuth', 'TestController@echoAuth');

        Route::resource( 'life', 'LifeController');
//        Route::get( 'life/parameters/{id}', 'LifeController@parameters');
        Route::resource( 'parameters', 'ParametersController');
//        Route::resource( 'users', 'UserController');
    });
});
