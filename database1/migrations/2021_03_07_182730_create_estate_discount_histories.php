<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstateDiscountHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estate_discount_histories', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->uuid('uuid')->unique();
            $table->uuid('discount_id');
            $table->string('name', 250);
            $table->string('estate_name', 250);
            $table->string('created_by', 250);
            $table->float('rate');
            $table->enum('notify', [0, 1])->default(0);
            $table->enum('status', ['activate', 'deactivate'])->default('activate');
            $table->dateTime('duration_start');
            $table->dateTime('duration_end');
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
        Schema::dropIfExists('estate_discount_histories');
    }
}
