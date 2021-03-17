<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfqs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('issued_by')->index();
            $table->foreignId('client_id')->index();
            $table->foreignId('service_request_id')->index();
            $table->string('batch_number')->unique();
            $table->enum('status', ['0', '1', '2'])->default('0');
            $table->enum('accepted', ['Yes', 'No'])->nullable();
            $table->unsignedInteger('total_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rfqs');
    }
}
