<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_type_id');
            $table->integer('wallet_id'); //The wallet being debited or credited
            $table->float('amount', 9, 2);
            $table->float('opening_balance', 9, 2);//Wallet balance before transaction
            $table->float('closing_balance', 9, 2);//Wallet balance after transaction
            $table->text('external_reference');
            $table->text('reference');
            $table->text('receipt_no');
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
        Schema::dropIfExists('transactions');
    }
}
