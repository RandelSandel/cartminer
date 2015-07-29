<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{

    // public function __construct() {

    //     $this->middleware('auth', ['only' => 'dashboard']);

    // }



    public function dashboard() {

        $uid = \Auth::user()->id;
        $name = \Auth::user()->name;

        return view('pages.dashboard', compact('uid', 'name'));

        //return view('pages.dashboard');
    }



	public function index() {

		$carts = \App\Cart::paginate(15);
		return view('pages.index', compact('carts'));
	}


   // public function update(Request $request){

   //      $id = $request->all()->id;
   //      $product = \App\Product::findOrFail($id);
   //      $product->update($request->all());

   //  }


    public function deleteProduct($id){

        $d = \App\Product::find($id);
        $d->delete();
        return "deleted";
    }



    public function product($id) {

        $cart_info = \App\Cart::find($id);

        $uName = $cart_info->user_id;

        $uid = \App\User::find($uName)->name;

        return view('pages.product', compact('cart_info', 'uid'));
    }


    public function prdlnks($id) {

        
        $p = \App\Product::where('cart_id', $id)->get();
            
        $pl = DB::table('products')->where('cart_id', $id)
                ->join('product_links', 'products.id', '=', 'product_links.product_id')
                ->get();

        return compact('p','pl');
    }


}




