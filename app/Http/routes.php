<?php

// Pages

get('test', function() { return view('pages.test'); });

Route::get('/', 'PagesController@index');

Route::get('product/{id}', ['as' => 'product_path', 'uses' => 'PagesController@product']);

Route::get('dashboard', 'PagesController@dashboard');


// API's



get('api/carts/{id}', function($id) { return App\Cart::where('user_id', $id)->get(); });

get('api/carts', function() {return App\Cart::all(); });

Route::get('api/itemlookup', 'ApiController@itemLookUp');

// we share this link, but late we need to secure it with unique primary keys
Route::get('api/fetchProducts/{id}', 'ApiController@fetchProducts');

Route::post('api/addNewLink', 'ApiController@addNewLink');

Route::post('api/editProduct/{id}', 'ApiController@editProduct');

Route::post('api/createProduct', 'ApiController@createProduct');

// deletes a product completely
Route::get('api/deleteproduct/{id}', 'ApiController@deleteProduct');

// deletes a product_link completely
Route::get('api/deleteLink/{id}', 'ApiController@deleteLink');

Route::post('api/searchamazon', 'ApiController@searchAmazon');


//Authentication

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
