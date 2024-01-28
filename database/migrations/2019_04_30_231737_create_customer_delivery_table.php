<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomerDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_delivery', function (Blueprint $table) {
            $table->integer('customer_id')->unsigned();
            $table->integer('delivery_id')->unsigned();

            $table->foreign('customer_id')
                ->references('id')
                ->on('customers')
                ->onDelete('cascade');

            $table->foreign('delivery_id')
                ->references('id')
                ->on('deliveries')
                ->onDelete('cascade');

            $table->primary(['customer_id', 'delivery_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_delivery');
    }
}
