<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProcurementExpense extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('procurement_expenses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('total_expenses');
            $table->string('expense_reason');
            $table->integer('agent_id');
            $table->integer('procurement_id');
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
        Schema::drop('procurement_expenses');
    }
}
