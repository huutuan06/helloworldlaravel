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

    Route::get('/admin/vogo/book/categories/', 'Dashboard\CategoryController@showAll')->name('book.categories');

    Route::delete('/admin/category/detach/{book}', 'Dashboard\CategoryController@detachBook')->name('category.detach.book');

    Route::group(['prefix' => '', 'note' => 'Routes for Category'], function () {

        Route::resource('/admin/category', 'Dashboard\CategoryController');

        Route::post('/admin/category/{category}', 'Dashboard\CategoryController@update')->name('category.update');

        Route::get('/admin/vogo/category/books', 'Dashboard\BookController@showBooksByCategory')->name('category.books');

    });

    Route::group(['prefix' => '', 'note' => 'Routes for User'], function () {

//        Route::resource('/admin/user', 'Dashboard\UserController');

//        Route::get('/admin/user', 'Dashboard\UserController@index')->name('get_list_user');
    });

    Route::group(['prefix' => '', 'note' => 'Routes for Customer'], function () {
        Route::get('/admin/customer/get', 'Dashboard\CustomerController@index')->name('get_list_customers');
        Route::post('/admin/customer/new', 'Dashboard\CustomerController@store')->name('create_customer');
    });

    Route::post('logout', 'Dashboard\LogoutController@logout')->name('logout');

//    Route::resource('/user', 'Dashboard\UserController');

//    Route::post('/admin/user/{user}', 'Dashboard\UserController@update')->name('user.update');

    Route::resource('/admin/order', 'Dashboard\OrderController');

    Route::get('/admin/vogo/order/detail/{detail}', 'Dashboard\OrderController@getOrderDetail')-> name('order.detail');

    Route::group(['prefix' => '', 'note' => 'MANAGERS'], function () {
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

        Route::post('admin/ajax/order/detail', 'Navigation\NavigationController@order')->name('ajax.order.detail');

        Route::get('admin/ajax/order', 'Navigation\NavigationController@orders')->name('ajax.order');

        Route::get('admin/ajax/dashboard', 'Navigation\NavigationController@dashboard')->name('ajax.dashboard');
    });

    Route::group(['prefix' => '', 'note' => 'MANAGERS'], function () {

        Route::get('admin/permission/index', 'Dashboard\PermissionController@index')->name('manager.index');

        Route::get('admin/permission/role/loading', 'Dashboard\PermissionController@roles')->name('manager.roles');

        Route::post('admin/permission/role/store', 'Dashboard\PermissionController@rolesStore')->name('manager.roles.store');

        Route::get('admin/permission/role/detail/{id}', 'Dashboard\PermissionController@roleDetail')->name('manager.roles.detail');

        Route::get('admin/permission/role/adjust/{id}', 'Dashboard\PermissionController@roleAdjust')->name('manager.roles.adjust');

        Route::get('admin/permission/role/delete/{id}', 'Dashboard\PermissionController@roleDelete')->name('manager.roles.delete');

        Route::post('admin/permission/role/update', 'Dashboard\PermissionController@roleUpdate')->name('manager.roles.update');

        Route::get('admin/permission/loading', 'Dashboard\PermissionController@permissions')->name('manager.permission');

        Route::post('admin/permission/store', 'Dashboard\PermissionController@permissionsStore')->name('manager.permission.store');

        Route::get('admin/permission/detail/{id}', 'Dashboard\PermissionController@permissionDetail')->name('manager.permission.detail');

        Route::get('admin/permission/revoke/{id}/{roleid}', 'Dashboard\PermissionController@revokeDetail')->name('manager.permission.revoke');

        Route::get('admin/permission/adjust/{id}/{roleid}', 'Dashboard\PermissionController@permissionAdjust')->name('manager.permission.adjust');

        Route::get('admin/permission/delete/{id}', 'Dashboard\PermissionController@permissionDelete')->name('manager.permission.delete');

        Route::post('admin/permission/update', 'Dashboard\PermissionController@permissionUpdate')->name('manager.permission.update');

    });
});


/**
 * Show laravel.log in browser to observe
 */
Route::group(['prefix' => '', 'note' => 'LOG'], function () {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
});
