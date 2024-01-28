<?php

use App\Models\LegalEntity;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLegalEntitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(LegalEntity::getTableName(), function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 170);
            $table->string('alias', 170);
            $table->unsignedTinyInteger('type');
            $table->unsignedTinyInteger('doc_flow_type');
            $table->unsignedTinyInteger('verification_status')->default(0);
            $table->boolean('is_nds_payer');
            $table->string('nds_payer_num')->nullable();
            $table->string('ipn');
            $table->string('edrpou')->nullable();
            $table->string('director_fio', 100);
            $table->string('tel', 30)->nullable();
            $table->string('legal_address', 170)->nullable();
            $table->string('actual_address', 170)->nullable();
            $table->string('accountant_email', 100)->nullable();

            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('customers');
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
        Schema::dropIfExists('legal_entities');
    }
}
