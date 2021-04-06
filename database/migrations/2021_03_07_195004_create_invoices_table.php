<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('user_id');
            $table->foreignId('service_request_id');
            $table->foreignId('rfq_id')->nullable();
            $table->string('invoice_number');
            $table->string('invoice_type');
            $table->float('total_amount')->nullable();
            $table->float('amount_due')->nullable();
            $table->float('amount_paid')->nullable();
            $table->enum('status', ['0' ,'1' ,'2'])->default('0');
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
        Schema::dropIfExists('invoices');
    }
}
