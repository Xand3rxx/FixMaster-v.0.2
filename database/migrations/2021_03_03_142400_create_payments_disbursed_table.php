<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsDisbursedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments_disbursed', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')
            ->constrained()
            ->onUpdate('CASCADE')
            ->onDelete('NO ACTION');

            $table->foreignId('recipient_id')->index();
            $table->foreignId('service_request_id')
            ->constrained()
            ->onUpdate('CASCADE')
            ->onDelete('NO ACTION');

            $table->foreignId('payment_mode_id')
            ->constrained()
            ->onUpdate('CASCADE')
            ->onDelete('NO ACTION');
            
            $table->string('payment_reference');
            $table->bigInteger('amount')->unsigned();
            $table->string('payment_date')->comment('Convert the Payment Date to human readable format e.g. January 6th 2021, 8:53:37pm');
            $table->text('comment')->nullable();
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
        Schema::dropIfExists('payments_disbursed');
    }
}
