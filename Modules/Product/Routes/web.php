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

use App\Http\Middleware\RouteAccessMiddleware;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:admin', RouteAccessMiddleware::ALIAS])->group(function () {
    Route::namespace('Admin')->group(function () {
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', 'ProductController@index')
            ->name('index');
        Route::get('create', 'ProductController@create')
            ->name('create');
        Route::post('/', 'ProductController@store')
            ->name('store');
        Route::get('{product}/edit', 'ProductController@edit')
            ->name('edit');
        Route::put('{product}', 'ProductController@update')
            ->name('update');
        Route::delete('{product}', 'ProductController@destroy')
            ->name('destroy');
    });
});
});
