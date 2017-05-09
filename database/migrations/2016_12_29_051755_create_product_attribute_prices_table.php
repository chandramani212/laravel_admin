<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductAttributePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_attribute_prices', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('price',15,2);
            $table->decimal('sale_price',15,2);
            $table->integer('edited_by');
            $table->smallInteger('status')->default('1');
            $table->integer('product_id');
            $table->integer('attribute_id');
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
        Schema::drop('product_attribute_prices');
    }
}
