<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('basic_qty');
            $table->decimal('basic_mrp',10,2);
            $table->string('basic_unit',45);
            $table->integer('updated_by')->unsigned();
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
        Schema::drop('stock_history');
    }
}
