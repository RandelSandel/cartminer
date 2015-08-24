<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CreateProductLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_links', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('custom_link_state');
            $table->string('custom_id');
            $table->string('merchant_name');
            $table->string('title');
            $table->integer('product_id')->unsigned();
            $table->string('product_link', 255);
            $table->decimal('price', 8, 2);
            $table->string('image_url');
            $table->integer('image_height');
            $table->integer('image_width');
            $table->integer('quantity');
            $table->decimal('shipping_cost', 8, 2);
            $table->boolean('shipping_free');
            $table->timestamps();

            $table->foreign('product_id')
                    ->references('id')
                    ->on('products')
                    ->onDelete('cascade');

        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('product_links');
    }
}
