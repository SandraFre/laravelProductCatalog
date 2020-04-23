<?php

use App\Http\Controllers\API\AuthenticateContoller;
use Illuminate\Http\Request;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('API')->name('api.')->group(function ()
{
    Route::prefix('auth')->group(function(){
        Route::post('login', 'AuthenticateContoller@login')->name('login');

        Route::middleware('auth:sanctum')->group(function(){
            Route::post('logout', 'AuthenticateContoller@logout')->name('logout');
            Route::get('me', 'AuthenticateContoller@me')->name('me');
        });
    });

    Route::apiResource('categories', 'CategoryController')->only(['index', 'show']);
    Route::apiResource('products', 'ProductController')->only(['index', 'show']);

});

