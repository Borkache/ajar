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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/invoices', function () {
    return view('welcome');
});

Route::group(
    [
//        'middleware' => $resourceMiddleWares,
        'namespace' => 'Modules\Resource\Http\Controllers'
    ],
    function(){

        Route::post('/accounts/personal', 'AccountController@createPersonal');
        Route::post('/accounts/corporate', 'AccountController@createBusiness');
        Route::put('/accounts/{id}', 'AccountController@update');
        Route::delete('/accounts/{id}', 'AccountController@delete');

        Route::post('/accounts/{id}/ibs', 'IbController@create')
            ->middleware(['request.platform_header_check']);

        Route::post('/accounts/{id}/traders', 'PlatformAccountController@create')
            ->middleware(['request.platform_header_check']);
        Route::put('/traders/{id}', 'PlatformAccountController@update');
        Route::delete('/traders/{id}', 'PlatformAccountController@delete');

    }
);