<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Product_link extends Model
{
    protected $fillable = [
    	'merchant_name',
    	'prodcut_id', // this is only temporary
    	'product_link',
    	'price',
    	'quantity',
    	'shipping_cost',
    	'shipping_free'
    ];
}