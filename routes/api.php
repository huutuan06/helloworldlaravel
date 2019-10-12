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
Route::post('v1/mobile/user/create', 'API\AuthenticateController@create')->name('api_create_user');

/**
 * Case 2: Need Token in Header (After Application had logined successfully)
 */
Route::group(['middleware' => ['jwt.auth']], function() {

});