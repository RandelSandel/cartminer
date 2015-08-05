<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            
            $table->increments('id');
            $table->integer('cart_id')->unsigned();
            $table->string('product_name', 100);
            $table->text('product_description');
            $table->boolean('active');
            $table->integer('primary_product_link_id');
            $table->timestamps();
             // this references the id field on the carts table
            $table->foreign('cart_id')
                    ->references('id')
                    ->on('carts')
                    ->onDelete('cascade') ;
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('products');
    }
}