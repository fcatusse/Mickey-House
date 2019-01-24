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
Route::get('/', 'HomeController@index');


// =========== ORDERS ==========

Route::post('/order/new', 'OrderController@storeAndUpdate');


// =========== DISHES ==========

Route::get('/dishes', 'DishesController@index');
Route::get('/dish/{id}', 'DishesController@show');
Route::put('/dish/order', 'DishesController@updateServings');

// =========== CATEGORIES ==========

Route::group(['middleware' => 'IsAdmin'], function () {
    Route::get('admin/categories', 'CategoriesController@index');
    Route::get('admin/categories/create', 'CategoriesController@create');
    Route::get('admin/categories/{category}', 'CategoriesController@show');
    Route::post('admin/categories', 'CategoriesController@store');
    Route::put('admin/categories/{category}', 'CategoriesController@update');
    Route::delete('admin/categories/{category}', 'CategoriesController@destroy');
});

// =========== REVIEWS ==========

Route::get('/user/review/{order_id}', 'ReviewsController@index')->middleware('auth');
<<<<<<< HEAD
Route::post('/user/review', 'ReviewsController@store')->middleware('auth');
=======
Route::post('/user/review', 'ReviewsController@store')->middleware('auth'); 
>>>>>>> update routes
