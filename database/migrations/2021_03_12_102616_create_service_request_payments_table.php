<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_request_payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('payment_id')->unique();
            $table->foreignId('service_request_id');
            $table->integer('amount')->unsigned();
            $table->string('unique_id', 191)->unique()->comment('e.g. REF-36786429');
            $table->enum('payment_type', ['initial-service-request', 'diagnosis', 'RFQ', 'others']);
            $table->softDeletes();
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
        Schema::dropIfExists('service_request_payments');
    }
}