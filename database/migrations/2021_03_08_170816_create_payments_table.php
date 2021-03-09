<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->foreignId('user_id');
            $table->integer('amount')->unsigned();
            $table->enum('payment_channel', ['paystack','flutterwave','offline','wallet']);
            $table->enum('payment_for', ['e-wallet','service-request']);
            $table->string('unique_id');
            $table->string('reference_id', 191)->unique();
            $table->string('transaction_id', 191)->nullable();

            $table->enum('status', ['success','pending','failed','timeout']);
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
        Schema::dropIfExists('payments');
    }
}
