<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

	Route::group(['prefix' => 'user'], function(){
	    Route::get('/', 'API\UserController@getUser');
	    Route::get('bank', 'API\UserController@bank');
	    Route::post('fetchbank', 'API\UserController@fetchbank');
	    Route::put('password', 'API\UserController@password');
	    Route::put('{id}', 'API\UserController@updateUser');
	});

	

	Route::group(['prefix' => 'crypto'], function(){
	    Route::get('/', 'API\CryptoController@index');
	    Route::get('{id}', 'API\CryptoController@show');
    });

	Route::get('/getrates', 'API\UserController@getrates');
	Route::get('/withdraw', 'API\UserController@withdraw');
	Route::post('/withdraw', 'API\UserController@storewithdraw');

	Route::post('/postcrypto', 'API\CryptoController@postcrypto');

    Route::group(['prefix' => 'network'], function(){
	    Route::get('/', 'API\NetworkController@index');
	    Route::post('/', 'API\NetworkController@store');
	    Route::get('{id}', 'API\NetworkController@show');
    });

    Route::group(['prefix' => 'invoice'], function(){
	    Route::group(['prefix' => 'network'], function(){
		    Route::get('{ref_id}', 'API\NetworkController@invoice');
		    Route::post('', 'API\NetworkController@postinvoice');
	    });
    });
    
    Route::group(['prefix' => 'transaction'], function(){
    	Route::group(['prefix' => 'airtime'], function(){
		    Route::get('/', 'API\NetworkController@transaction_airtime');
		    Route::delete('{id}', 'API\NetworkController@delete_airtime');
	    });

	    Route::group(['prefix' => 'crypto'], function(){
		    Route::get('/', 'API\CryptoController@transaction_crypto');
	    });

	    Route::group(['prefix' => 'account'], function(){
		    Route::get('/', 'API\UserController@account');
	    });
    });
	Route::get('/', 'API\UserController@getUser');

	Route::get('resend', 'API\UserController@resend');