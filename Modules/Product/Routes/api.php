<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\Api\Http\Middleware\ApiPrivateMiddleware;

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


Route::middleware(ApiPrivateMiddleware::class)->namespace('API')->name('api.')->group(function () {
    Route::apiResource('products', 'ProductController')->only(['index', 'show']);
    Route::apiResource('categories', 'CategoryController')->only(['index', 'show']);
});
