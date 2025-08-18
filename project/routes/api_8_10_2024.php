<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
// , 'middleware' => ['auth.api']
// Route::group(['prefix' => 'user', 'middleware' => ['auth.api'], 'namespace' => 'Api'], function () {

//     // Route::get('/get', function (Request $request) {
//     //     print_r($request->all());
//     // });

//     // Route::get('/get', 'UserController@getUserData');
//     Route::get('/get', ['as' => '', 'uses' => 'UserController@getUserData']);
//     // Route::get('/get', function(Request $request) {
//     //     echo "hello";
//     // });
// });


Route::get('health-status', function() {
    return response()->json([
        "status" => true,
        "message" => "Dalmia LAMS is Running."
    ]);
});

Route::group(['prefix' => 'user', 'middleware' => ['auth.api']], function () {
    Route::get('health-status', function() {
    return response()->json([
        "status" => true,
        "message" => "Dalmia LAMS is Running."
    ]);
});

    Route::post('get', ['as' => '', 'uses' => 'App\Http\Controllers\Api\UserController@getUserData']);
    Route::post('create', ['as' => '', 'uses' => 'App\Http\Controllers\Api\UserController@createUser']);
    Route::post('update/status', ['as' => '', 'uses' => 'App\Http\Controllers\Api\UserController@updateStatus']);
});

