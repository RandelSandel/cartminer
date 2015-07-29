<?php

// Routes

get('test', function() {
	return view('pages.test');
});

Route::get('/', 'PagesController@index');

Route::get('product/{id}', ['as' => 'product_path', 'uses' => 'PagesController@product']);

Route::get('dashboard', 'PagesController@dashboard');


// API


get('api/carts/{id}', function($id) {

	return App\Cart::where('user_id', $id)->get();

});

get('api/carts', function() {

	// get all carts that belong to the current authenticated user
	// this includes carts created, using, and following
	
	return App\Cart::all();
});


get('api/products', function() {
	return App\Product::all();
});


get('api/products/{id}', function($id) {

	$P = App\Product::where('cart_id', $id)->get();

	return $P;
});


Route::get('api/prdlnks/{id}', 'PagesController@prdlnks');


get('api/product_links/{id}', function ($id) {

	$pid = array();

	$pid []= $id;

	$pid []= App\Product_link::where('product_id', $id)->get();

	return $pid;

});


get('api/merchants/{id}', function ($id) {

	$m = App\Merchant::find($id);
	return $m;
});


// Route::post('api/editProduct', 'PagesController@update');

post('api/editProduct/{id}', function($id) {

	$product = App\Product::find($id);
	
	Debugbar::info($product);

	// Debugbar::info(Request::get('product_description'));
	$inputProductDescription = Request::get('product_description');
	$inputProductName = Request::get('product_name');

	$product->product_description = $inputProductDescription;
	$product->product_name = $inputProductName;

	if($product->save()) {
		return Response::json(array('success' => true), 200);
	}

	return;
	
});


post('api/createProduct', function() {
	
	$data = App\Product::create(Request::all());

	if($data->save()) {
		return Response::json(array('success' => true, 'last_insert_id' => $data->id), 200);
	}

});

// deletes a product completely
Route::get('api/deleteproduct/{id}', 'PagesController@deleteProduct');



//Authentication

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);