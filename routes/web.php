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

Route::get('/users/edit/{id}', 'UsersController@edit')->name('user.edit');
Route::put('/users/edit/{user}', 'UsersController@update')->name('user.update');

Route::get('/users/password/{id}', 'UsersController@psw_edit')->name('password.edit');
Route::put('/users/password/{user}', 'UsersController@psw_update')->name('password.update');

//============== HOME =========


Route::get('/home', 'DishesController@index')->name('home');
Route::get('/', 'DishesController@index');


// =========== ORDERS ==========

Route::post('/orders/new', 'OrderController@storeAndUpdate')->middleware('auth');
Route::get('/orders/show', 'OrderController@showAll')->name('orders.show')->middleware('auth');

// =========== DISHES ==========

Route::get('/dishes', 'DishesController@index')->name('dish.show.all');
Route::get('/dishes/map', 'DishesController@map_dishes')->name('dish.map');
Route::get('/dishes/me', 'DishesController@indexCurrentUser')->name('dish.show.mine');

Route::get('/dish/create', 'DishesController@create')->name('create.dish');
Route::put('/dish/create', 'DishesController@store');

Route::get('/dish/edit/{dish}', 'DishesController@edit')->name('dish.edit');
Route::put('/dish/edit/{dish}', 'DishesController@update');

Route::get('/dish/{id}', 'DishesController@show')->name('dish.show');
Route::put('/dish/order', 'DishesController@updateServings')->middleware('auth');

Route::get('/dish/hide/{dish}', 'DishesController@hide')->name('dish.hide');

// =========== ADMIN ==========

Route::group(['middleware' => 'IsAdmin'], function () {
    // =========== CATEGORIES ==========
    Route::get('admin/categories', 'CategoriesController@index')->name('adminCat');
    Route::get('admin/categories/create', 'CategoriesController@create');
    Route::get('admin/categories/{category}', 'CategoriesController@show');
    Route::post('admin/categories', 'CategoriesController@store');
    Route::put('admin/categories/{category}', 'CategoriesController@update');
    Route::delete('admin/categories/{category}', 'CategoriesController@destroy');

    // =========== REVIEWS  ==========
    Route::get('admin/reviews', 'ReviewsController@admin')->name('adminRev');
    Route::get('admin/reviews/{review_id}/delete', 'ReviewsController@delete');

    // =========== ADMIN PANEL ==========
    Route::get('/admin', 'AdminController@index')->name('adminPanel');
});

// =========== REVIEWS ==========

Route::get('/user/review/{order_id}', 'ReviewsController@index')->middleware('auth');
Route::post('/user/review', 'ReviewsController@store')->middleware('auth');
