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

/**
 * Import content inside Laravel Framework
 * Auth: point using object Authenticate in Laravel.
 * Route: point using object Route and allow you to navigate all other directions
 */
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::resource('/admin/book', 'Dashboard\BookController');

    Route::post('/admin/book/{book}', 'Dashboard\BookController@update')->name('book.update');

    Route::get('/admin/book/scrawl/top_selling', 'Dashboard\BookController@topselling')->name('book.topselling');


    Route::group(['prefix' => '', 'note' => 'Routes for Category'], function () {
        Route::resource('/admin/category', 'Dashboard\CategoryController');

        Route::post('/admin/category/{category}', 'Dashboard\CategoryController@update')->name('category.update');

        Route::get('/admin/vogo/category/books', 'Dashboard\BookController@showBooksByCategory')->name('category.books');

    });


    Route::delete('/admin/category/detach/{book}', 'Dashboard\CategoryController@detachBook')->name('category.detach.book');

    Route::resource('/admin/user', 'Dashboard\UserController');

    Route::post('logout', 'Dashboard\LogoutController@logout')->name('logout');


    Route::resource('/user', 'Dashboard\UserController');

    Route::post('/admin/user/{user}', 'Dashboard\UserController@update')->name('user.update');


    /**
     * Using Ajax to navigate page
     */
    Route::get('/admin', 'Dashboard\DashboardController@index')->name('admin.index');

    Route::get('admin/ajax/book', 'Navigation\NavigationController@book')->name('ajax.book');

    Route::get('admin/ajax/category', 'Navigation\NavigationController@category')->name('ajax.category');

    Route::get('admin/ajax/user', 'Navigation\NavigationController@user')->name('ajax.user');

    Route::get('admin/ajax/user/customer', 'Navigation\NavigationController@customer')->name('ajax.user');

    Route::get('admin/ajax/cms/{cms}', 'Navigation\NavigationController@cms')->name('ajax.cms');

    Route::post('admin/ajax/books', 'Navigation\NavigationController@books')->name('ajax.category.books');

    Route::get('admin/ajax/dashboard', 'Navigation\NavigationController@dashboard')->name('ajax.dashboard');
});


/**
 * Show laravel.log in browser to observe
 */
Route::group(['prefix' => '', 'note' => 'LOG'], function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});
