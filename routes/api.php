<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;


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


    Route::post('login', [UserController::class, 'login']);
    Route::post('register', [UserController::class, 'register']);
    Route::resource('products', ProductController::class);
    // Route::get('/products', 'ProductController@index');
    Route::post('/upload-file', [ProductController::class, 'uploadFile']);
    // Route::get('/products/{product}', 'ProductController@show');
    Route::get('/users','UserController@index');
    Route::get('users/{user}',[UserController::class, 'show']);
    Route::patch('users/{user}','UserController@update');
    Route::get('users/{user}/orders',[UserController::class, 'showOrders']);
    Route::post('orders/create',[OrderController::class, 'store']);
    Route::post('products/add',[ProductController::class, 'store']);
    // Route::patch('products/{product}/units/add','ProductController@updateUnits');
    Route::patch('orders/{order}/deliver','OrderController@deliverOrder');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
