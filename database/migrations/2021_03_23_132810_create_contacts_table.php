<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
            $table->id();

            /*the following adjustment is because of the fault in the contact table*/
            //nullable because my contact book dont have user_id
            $table->foreignId('user_id')->index()->nullable();
            // $table->string('name')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            // newly added
            $table->foreignId('state_id')->nullable();
            $table->foreignId('lga_id')->nullable();
            $table->foreignId('town_id')->nullable();

            $table->foreignId('account_id')->index();
            $table->foreignId('country_id')->index();
            $table->tinyInteger('is_default')->nullable();
            $table->string('phone_number', 30)->unique();
            $table->longText('address');
            $table->double('address_longitude');
            $table->double('address_latitude');

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
        Schema::dropIfExists('contacts');
    }
}
