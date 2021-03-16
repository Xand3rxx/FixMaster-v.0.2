<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientDiscountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_discounts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->uuid('discount_id');
            $table->uuid('uuid')->nullable();
            $table->integer('user_id')->nullable();
            $table->string('discount_name', 250);
            $table->string('entity', 250);
            $table->float('rate');
            $table->enum('notify', [0, 1])->default(0);
            $table->enum('status', ['activate', 'deactivate'])->default('activate');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_discounts');
    }
}
