<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Product extends Model
{
    protected $fillable = [
    	'id',
    	'cart_id',
    	'product_name',
    	'product_description',
    	'active',
        'primary_product_link_id'
    ];

 //    public function cart()
	// {
	// 	return $this->belongsTo('App\Cart');
	// }

}