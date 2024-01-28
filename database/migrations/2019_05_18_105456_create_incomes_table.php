<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('number')->nullable();
            $table->timestamp('create_date')->useCurrent();
            $table->timestamp('payment_date')->nullable()->default(null);
            $table->integer('value')->unsigned();
            $table->string('description')->nullable()->default(null);

            $table->integer('legal_entity_id')->unsigned();
            $table->foreign('legal_entity_id')->references('id')->on('legal_entities');
            $table->bigInteger('invoice_id')->unsigned();
            $table->foreign('invoice_id')->references('id')->on('invoices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incomes');
    }
}
