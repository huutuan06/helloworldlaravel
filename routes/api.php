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
/**
 * Login with social
 */
Route::post('v1/mobile/user/login', 'API\AuthenticateController@login')->name('api_login_social');

/**
 * Load List Books from server
 */
Route::get('v1/mobile/get/books', 'API\BookController@index')->name('api_get_books');

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
    Route::post('/v1/mobile/user/profile', 'API\AuthenticateController@profile');
});
