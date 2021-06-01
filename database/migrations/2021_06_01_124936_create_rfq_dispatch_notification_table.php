<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRfqDispatchNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rfq_dispatch_notification', function (Blueprint $table) {
            $table->id();
    
            $table->foreignId('rfq_id');
            $table->foreignId('supplier_id');
            $table->enum('notification', ['On', 'Off'])->default('On');
            $table->enum('dispatch', ['Yes', 'No'])->default('No');
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
        Schema::dropIfExists('rfq_dispatch_notification');
    }
}
