<?php

use App\Models\ServiceRequestReport;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServiceRequestReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_request_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('service_request_id');
            $table->foreignId('user_id');
            $table->foreignId('sub_service_id')->nullable();
<<<<<<< Updated upstream
            $table->enum('stage', ServiceRequestReport::STAGES)->default(ServiceRequestReport::STAGES[0]);
            $table->enum('type', ServiceRequestReport::TYPES);
            $table->text('report');
=======
            $table->enum('type', ['Diagnostic', 'Sub-Service']);
            $table->foreignId('causal_agent_id');
            $table->text('causal_reason');
            $table->text('report')->nullable();
>>>>>>> Stashed changes
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
        Schema::dropIfExists('service_request_reports');
    }
}
