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
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->uuid('uuid');
            $table->string('unique_id')->unique()->comment('e.g RFQ-C85BEA04');
            $table->foreignId('issued_by');
            $table->foreignId('client_id');
            $table->foreignId('service_request_id');
            $table->enum('status', ['Pending', 'Awaiting', 'Delivered'])->default('Pending');
            $table->enum('accepted', ['Yes', 'No'])->default('No');
            $table->unsignedInteger('total_amount')->nullable()->default(0);
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
        Schema::dropIfExists('rfqs');
    }
}
