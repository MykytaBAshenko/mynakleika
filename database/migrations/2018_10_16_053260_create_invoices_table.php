<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvoicesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoices', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->string('number', 20);
			$table->integer('legal_entity_id')->unsigned();
			$table->integer('status');
			$table->timestamp('create_date')->useCurrent();
			$table->timestamp('payment_date')->nullable()->default(null);
			$table->integer('sum')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('invoices_has_orders');
		Schema::dropIfExists('invoices');
	}
}
