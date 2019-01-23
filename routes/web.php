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

// Test Habib pour git
// test Camille pour git

Route::get('/', function () {
    return view('welcome');
});

// =========== ORDERS ==========

Route::post('/order/new', 'OrderController@store');


// =========== DISHES ==========

Route::get('/dish/{id}', 'DishesController@show');

Route::put('/dish/order', 'DishesController@updateServings');
