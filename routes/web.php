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
Route::get('/users/index', 'UsersController@index')->name('user.index')->middleware('auth');

Route::get('/users/show/{id}', 'UsersController@show')->name('user.show');
Route::get('/users/best', 'UsersController@showBest')->name('user.best');

Route::get('/users/edit', 'UsersController@edit')->name('user.edit')->middleware('auth');
Route::put('/users/edit', 'UsersController@update')->name('user.update')->middleware('auth');

Route::get('/users/password/{id}', 'UsersController@psw_edit')->name('password.edit')->middleware('auth');
Route::put('/users/password/{user}', 'UsersController@psw_update')->name('password.update')->middleware('auth');

Route::post('users/{user}/follow', 'UsersController@follow')->name('follow')->middleware('auth');
Route::delete('users/{user}/unfollow', 'UsersController@unfollow')->name('unfollow')->middleware('auth');

//============== HOME =========

Route::get('/home', 'DishesController@index')->name('home');
Route::get('/', 'DishesController@index');

// =========== ORDERS ==========

Route::post('/orders/new', 'OrderController@storeAndUpdate')->name('orders.new')->middleware('auth');
Route::get('/orders/show', 'OrderController@showAll')->name('orders.show')->middleware('auth');

// =========== DISHES ==========

Route::post('/dishes/search/', 'DishesController@search');

Route::get('/dishes', 'DishesController@index')->name('dish.show.all');
Route::get('/dishes/map', 'DishesController@map_dishes')->name('dish.map')->middleware('auth');
Route::get('/dishes/me', 'DishesController@indexCurrentUser')->name('dish.show.mine')->middleware('auth');

Route::get('/dish/create', 'DishesController@create')->name('create.dish')->middleware('auth');
Route::put('/dish/create', 'DishesController@store')->middleware('auth');

Route::get('/dish/edit/{dish}', 'DishesController@edit')->name('dish.edit');
Route::put('/dish/edit/{dish}', 'DishesController@update');

Route::get('/dish/{id}', 'DishesController@show')->name('dish.show');
Route::put('/dish/order', 'DishesController@updateServings')->middleware('auth');

Route::get('/dish/hide/{dish}', 'DishesController@hide')->name('dish.hide')->middleware('auth');

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

// =========== DEMANDS ==========

Route::get('/user/demand', 'DemandController@index')->name('create.demand')->middleware('auth');
Route::post('/user/demand', 'DemandController@store')->middleware('auth');
Route::get('/demands', 'DemandController@board');

// ========= NOTIFICATIONS ===========

Route::get('/notifications', 'UsersController@notifications')->middleware('auth');
