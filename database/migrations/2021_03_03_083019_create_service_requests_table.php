<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Temporary schema for Service Requests
        Schema::create('service_requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id(); 
            $table->uuid('uuid')->unique();
		    $table->foreignId('client_id');
            $table->foreignId('service_id');
            $table->string('unique_id')->unique();
            $table->foreignId('state_id')->nullable();
            $table->foreignId('lga_id')->nullable();
            $table->foreignId('town_id')->nullable();
            $table->foreignId('price_id');
            $table->foreignId('contact_id');
            $table->foreignId('client_discount_id')->nullable();
            $table->string('client_security_code')->unique();
            $table->foreignId('status_id')->default(1);
            $table->text('description');
            $table->bigInteger('total_amount')->unsigned();
            $table->dateTime('preferred_time')->nullable();
            $table->enum('has_client_rated', ['Yes', 'No'])->default('No');
            $table->enum('has_cse_rated', ['Yes', 'No'])->default('No');
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
        Schema::dropIfExists('service_requests');
    }
}
