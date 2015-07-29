<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Active_product extends Model
{
    protected $fillable = [
    	'product_id', //temporary
    	'activated',
    	'purchased',
    	'shipped',
    	'deleted',
    	'est_arrival_date'
    ];
}