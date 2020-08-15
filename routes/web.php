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

Auth::routes();
//Route::get('/', 'LiveController@index')->name('index');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/verify/{confirmationCode}', 'LiveController@confirm');
Route::get('/callback', 'LiveController@callback');

Route::group(['prefix' => 'admin'], function(){
	Route::group(['prefix' => 'services'], function(){
	    Route::get('/', 'HomeController@services')->name('services');

	    Route::group(['prefix' => 'crypto'], function(){
		    Route::get('/', 'CryptoController@index')->name('crypto');
		    Route::post('/', 'CryptoController@store');
		    Route::put('{id}', 'CryptoController@update');
		    Route::get('{id}', 'CryptoController@show');
		    Route::delete('{id}', 'CryptoController@destroy');
	    });

	    Route::group(['prefix' => 'btc'], function(){
		    Route::post('/', 'BtcController@store');
		    Route::put('{id}', 'BtcController@update');
		    Route::delete('{id}', 'BtcController@destroy');
	    });

	    Route::group(['prefix' => 'airtime'], function(){
		    Route::get('/', 'AirtimeController@index')->name('airtime');
		    
		    Route::post('/', 'AirtimeController@store');
		    Route::put('{id}', 'AirtimeController@update');
		    Route::get('{id}', 'AirtimeController@show');
		    Route::delete('{id}', 'AirtimeController@destroy');
	    });

	    Route::group(['prefix' => 'line'], function(){
		    Route::post('/', 'LineController@store');
		    Route::put('{id}', 'LineController@update');
		    Route::delete('{id}', 'LineController@destroy');
	    });
	});

	Route::group(['prefix' => 'transactions'], function(){
    	Route::group(['prefix' => 'airtime'], function(){
		    Route::get('/', 'AirtimeController@transaction_airtime');
		    Route::get('/{ref_id}', 'AirtimeController@edit');
		    Route::delete('{ref_id}', 'AirtimeController@delete_airtime');
	    });

	    Route::group(['prefix' => 'crypto'], function(){
		    Route::get('/', 'CryptoController@transaction_crypto');
		    Route::get('/{ref_id}', 'AirtimeController@edit');
		    Route::delete('{ref_id}', 'AirtimeController@delete_airtime');
	    });
    });
	
	Route::get('wallet', 'HomeController@account')->name('account');
	Route::get('users', 'HomeController@users')->name('users');
	Route::delete('deleteuser/{id}', 'HomeController@deleteuser');
	Route::get('searchaccount/{id}', 'HomeController@searchaccount')->name('searchaccount');
	Route::post('changepassword', 'HomeController@adminchangepassword');

	Route::group(['prefix' => 'withdraw'], function(){
        Route::get('/', 'HomeController@withdraw');
        Route::get('{id}', 'HomeController@showwithdraw');
    });

     Route::group(['prefix' => 'setting'], function(){
        Route::get('/', 'SettingController@index')->name('settings');
        Route::put('{id}', 'SettingController@update');

        Route::post('admin', 'SettingController@create_admin');
        Route::put('/admin/{id}', 'SettingController@update_admin');
        Route::delete('admin/{id}', 'SettingController@destroy_admin');
        Route::put('logo/{id}', 'SettingController@logoupdate');
        Route::get('/password', 'SettingController@passwordget')->name('password');
        Route::post('/password', 'SettingController@password')->name('changePassword');
    });
});
Route::get('{path}', 'HomeController@index')->where('path', '(.*)');
Route::get('{path}/{name}', 'HomeController@index')->where('path', '(.*)')->where('name', '(.*)');