<?php

namespace App\Http\Controllers;

use DB;
use Debugbar;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\Operations\Lookup;
use ApaiIO\ApaiIO;


class ApiController extends Controller
{


	public function deleteProduct($id) {

        $d = \App\Product::find($id);
        $d->delete();
        return "deleted";
    }


    public function deleteLink($id) {

        $d = \App\Product_link::find($id);
        $d->delete();
        return "deleted";
    }


    public function createProduct(Request $request) {

        $data = \App\Product::create($request->all());

        if($data->save()) {
            return \Response::json(array('success' => true, 'last_insert_id' => $data->id), 200);
        }

    }

	
	public function fetchProducts($id) {

        Debugbar::info('hello');

        $products = \App\Product::where('cart_id', $id)->get();

        $productLength = count($products); 
        $productIdArray = array();
        $idAndLinkArray = array();

        for($i = 0; $i < $productLength; $i++) {
            
            $singleProductId = $products[$i]['id'];
            $productIdArray[] = $singleProductId; 
        };

        for($n = 0; $n < $productLength; $n++) {

            $singleProductLink = \App\Product_link::where('product_id', $productIdArray[$n])->get();

            // we go through each product link and check to see which ones are custom and which ones are taken from an online merchant
            // if the product link is taken from a merchant ( is not custom ) we use the ASIN to get the up to date product info from the merchant
           
            // get the length of the $singleProductLink array
            $numberOfLinksInSingleProduct = count($singleProductLink);
           
            // use a for loop to go through each product_link
            for ($x = 0; $x < $numberOfLinksInSingleProduct; $x++) {

                // if the product_link custom_link != 0 then get updated info from amazon
                if ($singleProductLink[$x]['custom_link_state'] != 0) {

                    $ASIN_id = $singleProductLink[$x]['custom_id'];
                    
                    // use the itemLookUp function to fetch the updated data
                    $itemToBeAdded = $this->itemLookUp($ASIN_id);

                    $price = $itemToBeAdded['Items']['Item']['Offers']['Offer']['OfferListing']['Price']['FormattedPrice'];
                    $product_link = $itemToBeAdded['Items']['Item']['DetailPageURL'];
                    $title = $itemToBeAdded['Items']['Item']['ItemAttributes']['Title'];

                    
                    // then update each variable with the new data
                    $singleProductLink[$x]['product_link'] = $product_link;
                    $singleProductLink[$x]['price'] = $price;
                    $singleProductLink[$x]['title'] = $title;

                }
                // else we continue passing through the custom info
                else{
                    continue;
                }
            }
            // and custom_id (ASIN).
            $singleIdAndLinkArray = array('product_id' => $productIdArray[$n], 'product_links' => $singleProductLink);
            $idAndLinkArray [] = $singleIdAndLinkArray;
        };

        $productAndIDLinkArrayCombo = array('products' => $products, 'links' => $idAndLinkArray);

        return $productAndIDLinkArrayCombo; // cartminer.app/product/10
        //return dd($numberOfLinksInSingleProduct, $productAndIDLinkArrayCombo, $singleProductLink, $itemToBeAdded); //cartminer.app/api/fetchproducts/10

    }


	public function searchAmazon(Request $request) {

        // request all the search parameters for an amazon search
        // pass the parameters through the amazon function
       
        Debugbar::info('we called the search amazon debugger');
        Debugbar::info($request->get('searchAmazon'));
        $dataKeywords = $request->get('searchAmazon');
        Debugbar::info($dataKeywords);

        $conf = new GenericConfiguration();

        $conf
            ->setCountry('com')
            ->setAccessKey(getenv('AMZ_ACCESS_KEY'))
            ->setSecretKey(getenv('AMZ_SECRET_KEY'))
            ->setAssociateTag(getenv('AMZ_ASSOCIATE_TAG'))
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
    
        // return an object to vue instanc
        // return dd($parsedResponse['Items']['Item'][0]['Offers']['Offer']['OfferListing']['Price']['FormattedPrice']);
        return \Response::json($simpleArray);
        
    }


    public function editProduct(Request $request, $id) {

    	$product = \App\Product::find($id);
		
		Debugbar::info($product);

		// we use Request to get the products info sent through from the view
		Debugbar::info($request->get('product_description'));
		$inputProductDescription = $request->get('product_description');
		$inputProductName = $request->get('product_name');

		$product->product_description = $inputProductDescription;
		$product->product_name = $inputProductName;

		if($product->save()) {
			return \Response::json(array('success' => true), 200);
		}

		return;

    }


    public function addNewLink(Request $request) {

        // this is for non custom id's
        Debugbar::info($request->get('product_id'));

        // $data = \App\Product_link::create($request->all());
        $data = new \App\Product_link;
        $data->custom_id = $request->get('custom_id');
        $data->custom_link_state = 1;
        $data->product_id = $request->get('product_id');
        $data->image_url = $request->get('image_url');
        $data->product_link = $request->get('product_link');
        $data->title = $request->get('title');
        $data->price = $request->get('price');

        if($data->save()) {
            return \Response::json(array('success' => true, 'last_insert_id' => $data->id), 200);
        }

    }


    // ---------------some custom function------------------------

    public function itemLookUp($ASIN_id) {
        
        $conf = new GenericConfiguration();

        $conf
            ->setCountry('com')
            ->setAccessKey(getenv('AMZ_ACCESS_KEY'))
            ->setSecretKey(getenv('AMZ_SECRET_KEY'))
            ->setAssociateTag(getenv('AMZ_ASSOCIATE_TAG'))
            ->setRequest('\ApaiIO\Request\Soap\Request')
            ->setResponseTransformer('\ApaiIO\ResponseTransformer\ObjectToArray');


            $lookup = new Lookup();
            $lookup->setItemId($ASIN_id);
            $lookup->setResponsegroup(array('Small', 'Offers', 'Images'));

            $apaiIo = new ApaiIO($conf);
            $response = $apaiIo->runOperation($lookup);

            //return dd($response);\
            return $response;
    }

}



