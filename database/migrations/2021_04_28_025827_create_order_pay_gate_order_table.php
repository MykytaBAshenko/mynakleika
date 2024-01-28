<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderPayGateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_pay_gate_order', function (Blueprint $table) {
            $table->integer('order_id')->unsigned();
            $table->integer('pay_gate_order_id')->unsigned();

            $table->primary(['order_id', 'pay_gate_order_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_pay_gate_order');
    }
}
