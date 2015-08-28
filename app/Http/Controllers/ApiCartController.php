<?php

namespace App\Http\Controllers;

use DB;
use Debugbar;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ApiCartController extends Controller
{

	public function createCart(Request $request) {

		$data = \App\Cart::create($request->all());

		// Debugbar::info(\Auth::user()->id);
		// $data->user_id = \Auth::user()->id;
		
		if($data->save()) {
        	return \Response::json(array('success' => true, 'last_insert_id' => $data->id), 200);
        }
	}

	public function deleteCart($id) {

        $d = \App\Cart::find($id);
        $d->delete();
        return "deleted";
    
	}

	public function editCart(Request $request, $id) {

    	$cart = \App\Cart::find($id);
		
		Debugbar::info($cart);

		// we use Request to get the products info sent through from the view
		Debugbar::info($request->get('cart_name'));
		$inputCartDescription = $request->get('cart_description');
		$inputCartName = $request->get('cart_name');

		$cart->cart_description = $inputCartDescription;
		$cart->cart_name = $inputCartName;

		if($cart->save()) {
			return \Response::json(array('success' => true), 200);
		}
			
		return;
		
    }


}
