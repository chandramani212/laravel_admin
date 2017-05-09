<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->unsigned();
            $table->decimal('actual_mrp',10,2);
            $table->string('actual_attribute_name',50);
            $table->string('actual_uom',50);
            $table->decimal('change_mrp',10,2);
            $table->enum('price_type', ['PRICE', 'SELL_PRICE','CUSTOM_PRICE']);
            $table->string('change_attribute_name',50);
            $table->string('change_uom',50);
            $table->integer('qty');
            $table->decimal('product_total',10,2);
            $table->integer('product_id')->unsigned();
            $table->string('product_name',255);
            $table->integer('attribute_id')->unsigned();
            $table->text('comment');
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
        Schema::drop('order_details');
    }
}
