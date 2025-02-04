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

use Illuminate\Support\Facades\Route;
use Modules\Administration\Http\Middleware\RouteAccessMiddleware;

Route::namespace('Admin\Auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('login', 'LoginController@showLoginForm')
        ->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')
        ->name('logout');

    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')
        ->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')
        ->name('password.email');

    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')
        ->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')
        ->name('password.update');
});

Route::middleware(['auth:admin', RouteAccessMiddleware::ALIAS])->group(function () {
    Route::namespace('Admin')->group(function () {
        Route::get('admins/me', 'AdminController@me')
            ->name('admins.me');
        Route::resource('admins', 'AdminController')->except('show');
        Route::resource('roles', 'RoleController');
    });

});
