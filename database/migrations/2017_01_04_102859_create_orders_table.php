<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('customer_id')->unsigned();
            $table->integer('address_id')->unsigned();
            $table->decimal('order_total',10,2);
            $table->decimal('sub_total',10,2);
            $table->decimal('delivery_charge',10,2);
            $table->integer('created_by')->unsigned();
            $table->integer('updated_by')->unsigned();
            $table->integer('confirm_by')->unsigned();
            $table->text('comment');
            $table->enum('order_stage',['CREATED', 'UPDATED','CONFIRMED']);
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
        Schema::drop('orders');
    }
}
