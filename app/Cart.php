<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Cart extends Model
{
    protected $fillable = [
    	'user_id', //temporary for testing
    	'cart_name',
    	'cart_description',
    	'private',
    	'active',
    ];

    // public function product(){
    //     return $this->unique()->hasMany('App\Product');
    // }
}