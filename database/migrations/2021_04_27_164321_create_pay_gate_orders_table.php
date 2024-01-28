<?php

use App\Models\PayGateOrder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePayGateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pay_gate_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('status')->default(PayGateOrder::STATUS_REJECTED);
            $table->tinyInteger('paygate_id');
            $table->string('shop_bill_id', 20)->nullable();
            $table->string('bill_amount', 10)->nullable();
            $table->string('card_mask', 16)->nullable();
            $table->string('approval_code', 20)->nullable();

            $table->timestamp('created_at')->default(Carbon\Carbon::now());
            $table->timestamp('payed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pay_gate_orders');
    }
}
