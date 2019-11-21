<?php

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

/**
 * There are two cases:
 * Case 1: Show API from mobile request without authenticate with Token
 *
 * Assume we need SignUp/SigIn account from mobile. => LoginController,
 * RegisterController, LogOutController => AuthenticateController and put it inside folder API
 * Here is syntax: php artisan make:controller \API\AuthenticateController
 */
Route::post('v1/mobile/user/register', 'API\AuthenticateController@register')->name('api_register_user');
Route::post('v1/mobile/user/login', 'API\AuthenticateController@login')->name('api_login_user');
Route::post('v1/mobile/user/loginSocialNetwork', 'API\AuthenticateController@loginSocialNetwork')->name('api_login_social_network_user');

/**
 * Case 2: Need Token in Header (After Application had logined successfully)
 */
Route::group(['middleware' => ['jwt.auth']], function() {
    /**
     * Example to get data with access token
     * php artian route:list => see structure of /vi/mobile/book
     * Assume GET
     * Request: Header: Authorization
     *          Param: Bearer<Space><Token>
     */
    Route::resource('/v1/mobile/book', 'API\BookController');

    Route::get('test', function(){
        return response()->json(['foo'=>'bar']);
    });
});
