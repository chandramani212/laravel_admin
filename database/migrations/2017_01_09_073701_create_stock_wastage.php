<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockWastage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_wastage', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('basic_qty');
            $table->decimal('basic_mrp',10,2);
            $table->string('basic_unit',45);
            $table->string('reason',255);
            $table->integer('updated_by')->unsigned();
            $table->integer('added_by')->unsigned();
            $table->integer('stock_id')->unsigned();
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
        Schema::drop('stock_wastage');
    }
}
