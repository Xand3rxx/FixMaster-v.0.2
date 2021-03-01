<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessageTemplate extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_templates', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';

            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('title');
            $table->text('content');
            $table->enum('type', ['sms', 'email']);
            $table->enum('feature', ['CUSTOMER_REGISTRATION','PAYMENT_CONFIRMATION',
            'TECHNICIAN_ASSIGNED','DIAGNOSIS_VISIT','DIAGNOSIS_VISIT_RESCHEDULED',
            'DIAGNOSIS_COMPLETED', 'COMPLETION_ACCEPTANCE', 'COMPLETION_REJECTION',
            'DIAGNOSIS_PAYMENT_CONFIRMATION', 'COMPLETION_VISIT_SCHEDULED', 'SPARES_DELIVERY',
            'SPARES_DELIVERED', 'JOB_COMPLETED', 'CSE_ACCOUNT_CREATION',
            'PROFILE_UPDATE_CONFIRMATION', 'NEW_JOB_NOTIFICATION', 'ACCEPTANCE_NOTIFICATION',
            'DIAGNOSTIC_TIME_CONFIRMATION', 'CUSTOMER_PAYMENT_COMPLETION', 'SUPPLIER_SPARE_DISPATCH',
            'JOB_COMPLETION_SCHEDULE', 'RFQ_COMPLETION', 'DIAGNOSIS_COMPLETION',
            'JOB_COMPLETION_NOTIFICATION', 'APPOINTMENT_RESCHEDULE_REQUEST', 'TECHNICIAN_APPLICATION_SUBMITTED',
            'TECHNICIAN_APPLICATION_SUCCESSFUL', 'SUPPLIER_APPLICATION_SUBMITTED', 'SUPPLIER_NEW_JOB_NOTIFICATION',
            'SUPPLIER_SPARE_DELIVERY', 'SUPPLIER_SUCCESSFUL_SPARE_DELIVERY', 'DELIVERY_REJECTED_NOTIFICATION']);
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
        Schema::dropIfExists('message_templates');
    }
}
