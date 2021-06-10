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
Route::namespace('Api')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::get('logout', 'AuthController@logout');
    Route::post('save-profile-user', 'AuthController@profileUser')->name('save-profile-user')->middleware('jwtAuth');
    Route::get('get-profile','AuthController@getProfile')->name('profile')->middleware('jwtAuth');
    Route::post('change-password','AuthController@ChangePassword')->name('change-password')->middleware('jwtAuth');

    //rutas para los sliders
    Route::get('sliders','SliderController@sliders');
    Route::get('categories','CategoryController@categories');

    Route::get('orders','ShopController@getOrders')->middleware('jwtAuth');
    Route::get('detail-order/{id}','ShopController@getDetail')->middleware('jwtAuth');
    Route::post('store-shop','ShopController@store')->middleware('jwtAuth');


    Route::get('products','ProductController@products');
    Route::get('categories/{product_id}','ProductController@productsByCategory');


    Route::post('send-payment','ShopController@registerPayment')->middleware('jwtAuth');

});
