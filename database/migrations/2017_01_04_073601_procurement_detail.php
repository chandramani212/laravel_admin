<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcurementDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('procurement_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('procurement_id');
            $table->integer('product_id');
            $table->integer('purchase_qty');
            $table->string('uom');
            $table->decimal('budget_price',5,2);
            $table->decimal('purchase_price',5,2);
            $table->string('expenses');
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
