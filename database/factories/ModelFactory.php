<?php
require 'database/params/FactoryClass.php';
$factory->define(App\User::class, function ($faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => str_random(10),
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Profile::class, function ($faker) {
    $users = new UserID();
    $num = $users->user_id();
    return [
        'user_id' => $faker->unique()->randomElement($array = $num), // lists all id's from users table
        'bio' => $faker->sentence,
        'twitter_username' => $faker->userName,
        'facebook_username' => $faker->userName,
    ];
});
$factory->define(App\Cart::class, function ($faker) {
    $users = new UserID();
    $num = count($users->user_id());
    // we create Cart's that have non-unique users. A user can own many Cart's
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = $num), 
        'cart_name' => $faker->catchPhrase,
        'cart_description' => $faker->sentence($nbWords = 6),
        'private' => $faker->boolean($chanceOfGettingTrue = 25),
    ];
    
});
$factory->define(App\Product::class, function ($faker) {
    $carts = new CartID();
    $num = count($carts->cart_id());
    // a Product can only belong to one cart, and a cart can have null to many products
    return [
        'cart_id' => $faker->numberBetween($min = 1, $max = $num), 
        'product_name' => $faker->catchPhrase,
        'product_description' => $faker->sentence($nbWords = 10),
    ];
     
});
$factory->define(App\Merchant::class, function ($faker) {
        
    return [
        'merchant_name' => $faker->company,
        'merchant_home_link' => $faker->domainName,
        'merchant_email' => $faker->companyEmail,
    ];
     
});
$factory->define(App\Product_link::class, function ($faker) {
    $merchants = new MerchantID();
    $num2 = count($merchants->merchant_id());
    $products = new ProductID();
    $num = count($products->product_id());
        
    return [
        'merchant_name' => $faker->company,
        'product_id' => $faker->numberBetween($min = 1, $max = $num), 
        'product_link' => $faker->url,
        'price' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 2, $max = 2),
        'shipping_cost' => $faker->randomFloat($nbMaxDecimals = NULL, $min = 2, $max = 2),
        'shipping_free' => $faker->boolean($chanceOfGettingTrue = 50)
    ];
     
});
// id should be equal to the number of products
$factory->define(App\Active_product::class, function ($faker) {
        
    $products = new ProductID();
    $num = count($products->product_id());
    return [
        // should be equal to the number of products
        'product_id' => $faker->unique()->numberBetween($min = 1, $max = $num),
        'activated' => $faker->boolean($chanceOfGettingTrue = 50),
        'purchased' => $faker->boolean($chanceOfGettingTrue = 50),
        'shipped' => $faker->boolean($chanceOfGettingTrue = 50),
        'deleted' => $faker->boolean($chanceOfGettingTrue = 50),
        'est_arrival_date' => $faker->date($format = 'm-d-Y', $max = 'now'),
    ];
     
});
// one user can follow many other users, but only one once
$factory->define(App\Profile_follower::class, function ($faker) {
    $users = new UserID();
    $num = count($users->user_id());
            
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = $num), // can be anything..a user can only follow a profile once, but can follow many users
        'followers_id' => $faker->numberBetween($min = 1, $max = $num), // can't repeat itself if the relationship with user_id already exists
    ];
     
});
$factory->define(App\Cart_follower::class, function ($faker) {
    $users = new UserID();
    $num = count($users->user_id());
    $carts = new CartID();
    $num2 = count($carts->cart_id());
    return [
        'user_id' => $faker->numberBetween($min = 1, $max = $num),
        'cart_following_id' => $faker->numberBetween($min = 1, $max = $num2),
    ];
     
});
