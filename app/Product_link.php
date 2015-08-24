<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Product_link extends Model
{
    protected $fillable = [
    	'custom_link_state',
    	'custom_id',
    	'merchant_name',
    	'title',
    	'image_url',
    	'image_height',
    	'image_width',
    	'prodcut_id', // this is only temporary
    	'product_link',
    	'price',
    	'quantity',
    	'shipping_cost',
    	'shipping_free'
    ];
}