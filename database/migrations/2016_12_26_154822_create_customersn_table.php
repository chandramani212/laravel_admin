<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            
            $table->increments('id');
            $table->string('first_name',45);
            $table->string('last_name',45);
            $table->string('email',45);
            $table->string('delivery_prefer_time',45);
            $table->string('contact_no',45);
            $table->string('alternate_no',45);
            $table->dateTime('join_date');
            $table->integer('default_order_id')->unsigned();
            $table->integer('introduce_by')->unsigned();
            $table->integer('manage_by')->unsigned();
            $table->integer('added_by')->unsigned();
            $table->integer('updated_by')->unsigned();
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
        Schema::drop('customers');
    }
}
