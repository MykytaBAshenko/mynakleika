<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('material_name');
            $table->text('material_ref')->nullable();
            $table->double('material_price')->default(0);
            $table->boolean('in_stock')->default(true);
            $table->integer('layoutW')->default(330);
            $table->integer('layoutH')->default(330);
            $table->double('fieldW')->default(12.5);
            $table->double('fieldH')->default(12.5);
            $table->double('bleed')->default(2.5);
            $table->double('minW')->default(10);
            $table->double('minH')->default(10);
            $table->json('cost_printing');
            $table->json('cost_cut');
            $table->json('quantity_factor');
            $table->json('mat_glanec_covering');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
