<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('NO ACTION');

            $table->foreignId('category_id')
                ->constrained()
                ->onUpdate('CASCADE')
                ->onDelete('NO ACTION');

            $table->string('name')->unique();
            $table->uuid('url')->unique();
            $table->text('description');
            $table->string('image')->unique();
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
        Schema::dropIfExists('services');
    }
}