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

Route::post('login', 'AuthController@authenticate');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => ['jwt.verify']], function() {

    Route::get('logout', 'AuthController@logout');

    Route::group(['prefix' => 'posts'] , function (){
        Route::post('/' , 'PostController@store');
        Route::get('/' , 'PostController@index');
        Route::get('/{id}' , 'PostController@show');
    });

});
