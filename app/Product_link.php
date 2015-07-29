<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Product_link extends Model
{
    protected $fillable = [
    	'merchant_id',
    	'prodcut_id', // this is only temporary
    	'product_link',
    	'price',
    	'shipping_cost',
    	'shipping_free'
    ];
}