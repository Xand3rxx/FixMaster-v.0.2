<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Temporary schema for Service Requests
        Schema::create('service_requests', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->uuid('uuid')->unique();
		    $table->foreignId('user_id');
		    $table->foreignId('admin_id')->default(null);
		    $table->foreignId('cse_id')->default(null);
            $table->foreignId('technician_id')->default(null);

            $table->foreignId('service_id')
            ->constrained()
            ->onUpdate('CASCADE')
            ->onDelete('NO ACTION');
            
            $table->bigInteger('service_request_status_id')->index()->default(1);
		    $table->string('job_reference');
		    $table->string('security_code');
            $table->bigInteger('total_amount')->unsigned();
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
        Schema::dropIfExists('service_requests');
    }
}
