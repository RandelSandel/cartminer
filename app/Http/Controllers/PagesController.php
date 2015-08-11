<?php

namespace App\Http\Controllers;

use DB;
use Debugbar;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use ApaiIO\Configuration\GenericConfiguration;
use ApaiIO\Operations\Search;
use ApaiIO\ApaiIO;

class PagesController extends Controller
{

    // public function __construct() {

    //     $this->middleware('auth', ['only' => 'dashboard']);
    // }


    public function dashboard() {

        $uid = \Auth::user()->id;
        $name = \Auth::user()->name;
        return view('pages.dashboard', compact('uid', 'name'));
    }



	public function index() {

		$carts = \App\Cart::paginate(15);
		return view('pages.index', compact('carts'));
	}




    public function product($id) {

        $cart_info = \App\Cart::find($id);
        $uName = $cart_info->user_id;
        $uid = \App\User::find($uName)->name;
        return view('pages.product', compact('cart_info', 'uid'));
    }

}




