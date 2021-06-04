<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollaboratorsPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaborators_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('service_request_id');
            $table->foreignId('payment_id');
            $table->foreignId('user_id');
            $table->enum('service_type', ['Regular', 'Warranty']);
            $table->integer('flat_rate')->nullable();
            $table->integer('actual_labour_cost')->nullable();
            $table->integer('actual_material_cost')->nullable();
            $table->integer('retention_fee')->nullable();
            $table->integer('labour_markup_cost')->nullable();
            $table->integer('material_markup_cost')->nullable();
            $table->integer('royalty_fee')->nullable();
            $table->integer('logistics_cost')->nullable();
            $table->integer('tax_fee')->nullable();
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
        Schema::dropIfExists('collaborators_payments');
    }
}
