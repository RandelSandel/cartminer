<?php


use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;



class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();


        $numberUsers = 5;
        $numberCarts = 10;
        $numberMerchants = 5;
        $numberProducts = 50;
        factory('App\User', $numberUsers)->create();
        factory('App\Profile', $numberUsers)->create();
        factory('App\Cart', $numberCarts)->create();
        factory('App\Product', $numberProducts)->create();
        factory('App\Merchant', $numberMerchants)->create();
        factory('App\Product_link', 200)->create();
        factory('App\Active_product', $numberProducts)->create();
        factory('App\Profile_follower', 5)->create();
        factory('App\Cart_follower', 5)->create();



        Model::reguard();
    }
}