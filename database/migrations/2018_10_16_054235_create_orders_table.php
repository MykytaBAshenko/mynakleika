<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('order_ref', 191)->nullable();
            $table->text('order_comments')->nullable();
            $table->integer('production_status');
            $table->integer('finance_status');
            $table->string('format', 20);
            $table->unsignedMediumInteger('quantity');
            $table->unsignedInteger('quantity_per_sheet');
            $table->integer('chromaticity');
            $table->integer('lamination');
            $table->integer('delivery_cost')->default(0);
            $table->integer('cost')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('end_at')->nullable();
            $table->integer('customer_id')->unsigned()->nullable()->default(null);
            $table->integer('file_id')->unsigned();
            $table->integer('material_id')->unsigned();
            $table->integer('delivery_id')->unsigned();
        });

        DB::statement("ALTER TABLE orders AUTO_INCREMENT = 100001;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
