<?php

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

Route::middleware('auth.basic')->get('/user-basic', function (Request $request) {
    return $request->user();
});

//Route::apiResource('products', 'App\Http\Controllers\Api\ProductController');
//Route::apiResource('users', 'App\Http\Controllers\Api\UserController');
//Route::apiResource('categories', 'App\Http\Controllers\Api\CategoryController');

Route::get('categories/custom1', 'App\Http\Controllers\Api\CategoryController@custom1');
Route::get('products/custom1', 'App\Http\Controllers\Api\ProductController@custom1');
Route::get('products/custom2', 'App\Http\Controllers\Api\ProductController@custom2');
Route::get('products/custom3', 'App\Http\Controllers\Api\ProductController@custom3');
Route::get('products/custom4', 'App\Http\Controllers\Api\ProductController@listWithCategories');
Route::get('categories/report1', 'App\Http\Controllers\Api\CategoryController@report1');
Route::get('users/custom1', 'App\Http\Controllers\Api\UserController@custom1');


Route::middleware(['auth:api'])->group(function(){
    Route::apiResources([
        'products'      => 'App\Http\Controllers\Api\ProductController',
        'users'         => 'App\Http\Controllers\Api\UserController',
        'categories'    => 'App\Http\Controllers\Api\CategoryController'
    ]);
});

Route::middleware('throttle:5|rate_limit,1')->group(function(){
    Route::get('/guest', function () {
        echo "Guest";
    });

    Route::get('/guestlogin', function () {
        echo "Guest1";
    })->middleware('auth:api');
});

Route::post('/auth/login', 'App\Http\Controllers\Api\AuthController@login');

Route::post('/upload', 'App\Http\Controllers\Api\UploadController@upload');

Route::middleware('api-token')->group(function (){
    Route::get('/auth/token', function (Request $request) {
        $user = $request->user();

        return response()->json([
            'name' => $user->name,
            'access_token' => $user->api_token,
            'time' => time()
        ]);
    });
});


