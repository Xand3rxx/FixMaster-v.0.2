<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqBatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rfq_id')->index();
            $table->string('component_name');
            $table->string('model_number')->nullable();
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rfq_batches');
    }
}
