<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->foreignId('wallet_id')->index();
            $table->foreignId('service_request_id')->index();
            $table->string('payment_type');
            $table->string('payment_gateway');
            $table->string('reference_no');
            $table->unsignedInteger('amount');
            $table->text('firstname');
            $table->text('lastname');
            $table->text('email');
            $table->text('phone');
            $table->unsignedInteger('opening_balance');
            $table->unsignedInteger('closing_balance');
            $table->text('status');
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
        Schema::dropIfExists('wallet_transactions');
    }
}
