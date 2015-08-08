<?php

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;

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

	// we use Request to get the products info sent through from the view
	Debugbar::info(Request::get('product_description'));
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


post('api/searchamazon', function() {

	// request all the search parameters for an amazon search
	// pass the parameters through the amazon function
	
	Debugbar::info('we called the search amazon debugger');
	Debugbar::info(Request::get('searchAmazon'));
	$dataKeywords = Request::get('searchAmazon');
	Debugbar::info($dataKeywords);




	$conf = new GenericConfiguration();

	$conf
	    ->setCountry('com')
	    ->setAccessKey('AKIAJRZOBMHPLHDBMH4A')
	    ->setSecretKey('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')
	    ->setAssociateTag('peoplerally-20')
	    ->setRequest('\ApaiIO\Request\Soap\Request')
	    ->setResponseTransformer('\ApaiIO\ResponseTransformer\ObjectToArray');

	$search = new Search();
	$search->setCategory('All');
	$search->setKeywords($dataKeywords);
	$search->setResponsegroup(array('Small', 'Offers', 'Images'));

	$apaiIo = new ApaiIO($conf);
	$response = $apaiIo->runOperation($search);
	$parsedResponse = $response;

	//Debugbar::info($parsedResponse);

	// get count of items to loop through items from amazon
	$length = count($parsedResponse['Items']['Item']);
	// Debugbar::info($length);
	$simpleArray = array();
	// use for loop
	for($i = 0; $i < $length; $i++) {

		$p = $parsedResponse['Items']['Item'][$i];

		// push info to an array
		$simpleArray[] = $p;

	};
	
	// return an object to vue instance

	return Response::json($simpleArray);
	// return dd($parsedResponse['Items']['Item'][0]['Offers']['Offer']['OfferListing']['Price']['FormattedPrice']);
});

//Authentication

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);