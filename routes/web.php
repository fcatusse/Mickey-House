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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

// ============= USERS =========

Route::get('/users/show/{id}', 'UsersController@show')->name('user.show');

//============== HOME =========


Route::get('/home', 'HomeController@index')->name('home');

// =========== ORDERS ==========

Route::post('/order/new', 'OrderController@store');


// =========== DISHES ==========

Route::get('/dishes', 'DishesController@index');
Route::get('/dish/create', 'DishesController@create');
Route::put('/dish/create', 'DishesController@store');
Route::get('/dish/{id}', 'DishesController@show')->name('showdish');
Route::put('/dish/order', 'DishesController@updateServings');
Route::get('/dish/{id}', 'DishesController@show');

// =========== CATEGORIES ==========

Route::get('/categories', 'CategoriesController@index');
Route::get('/categories/{category}', 'CategoriesController@show');
Route::post('/categories', 'CategoriesController@store');
Route::put('/categories/{category}', 'CategoriesController@update');
Route::delete('/categories/{category}', 'CategoriesController@destroy');
