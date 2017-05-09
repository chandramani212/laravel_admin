<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductAttributePriceHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute_price_histories', function (Blueprint $table) {
            $table->increments('id'); // here vijay change id to product_id
            $table->decimal('price',15,2);    
            $table->decimal('sale_price',15,2);    
            $table->integer('attribute_id');
            $table->integer('edited_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
