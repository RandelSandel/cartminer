<?php

class UserID {
	public function user_id(){
	    $user_id_list = App\User::all()->toArray();
	    $user_end = array();
	    $list_length = count($user_id_list);
	        for ($i = 0; $i < $list_length; $i ++){
	            $user_end []= $user_id_list[$i]['id'];
	        }   
	        return $user_end;
	}
}
class CartID {
	public function cart_id(){
	    $user_id_list = App\Cart::all()->toArray();
	    $user_end = array();
	    $list_length = count($user_id_list);
	        for ($i = 0; $i < $list_length; $i ++){
	            $user_end []= $user_id_list[$i]['id'];
	        }   
	        return $user_end;
	}
}
class MerchantID {
	public function merchant_id(){
	    $user_id_list = App\Merchant::all()->toArray();
	    $user_end = array();
	    $list_length = count($user_id_list);
	        for ($i = 0; $i < $list_length; $i ++){
	            $user_end []= $user_id_list[$i]['id'];
	        }   
	        return $user_end;
	}
}
class ProductID {
	public function product_id(){
	    $user_id_list = App\Product::all()->toArray();
	    $user_end = array();
	    $list_length = count($user_id_list);
	        for ($i = 0; $i < $list_length; $i ++){
	            $user_end []= $user_id_list[$i]['id'];
	        }   
	        return $user_end;
	}
}
