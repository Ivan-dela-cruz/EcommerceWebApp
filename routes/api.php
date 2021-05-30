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
    Route::get('sliders','SliderController@index');
    Route::get('categorias','CategoryController@index');
    Route::get('productos','ProductController@index');
    Route::get('productos/{id}','ProductController@productsByCategory');
    Route::post('store-shop','ShopController@store')->middleware('jwtAuth');
    Route::get('orders','ShopController@getVentas')->middleware('jwtAuth');
    Route::get('detalle/{id}','ShopController@getDetalle');
    Route::post('send-payment','ShopController@registerPayment')->middleware('jwtAuth');

});