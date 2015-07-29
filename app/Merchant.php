<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Merchant extends Model
{
    protected $fillable = [
    	'merchant_name',
    	'merchant_home_link',
    	'merchant_email'
    ];
}