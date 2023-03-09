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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1', 'namespace' => 'API\v1'], function () {

	// Routes group for account services
    Route::group(['prefix' => 'services/account', 'namespace' => 'Services'], function () {
       Route::get('balance','AccountController@getBalance');
       Route::post('create','AccountController@create');
    });

    // Routes group for transfer services
    Route::group(['prefix' => 'services/transfer', 'namespace' => 'Services'], function () {
       Route::post('create','TransferController@create');
       Route::get('history','TransferController@history');
    });
});
