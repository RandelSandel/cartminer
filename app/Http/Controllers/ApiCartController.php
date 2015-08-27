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


}
