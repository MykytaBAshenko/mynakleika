<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->string('city', 100)->nullable();
            $table->string('address', 191)->nullable()->default(null);
            $table->string('contact_person', 50)->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->string('np_organization', 100)->nullable()->default(null);
            $table->string('np_warehouse', 191)->nullable()->default(null);
            $table->integer('np_payer')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}
