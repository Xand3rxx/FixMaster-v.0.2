<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\ServiceRequest;

class ServiceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serviceRequest = new ServiceRequest();
        $serviceRequest->user_id = '2';
        $serviceRequest->admin_id = '1';
        $serviceRequest->cse_id = '3';
        $serviceRequest->technician_id = '3';
        $serviceRequest->category_id = '3';
        $serviceRequest->service_id = '2';
        $serviceRequest->job_reference = 'REF-66EB5A26';
        $serviceRequest->security_code = 'SEC-27AEC73E';
        $serviceRequest->service_request_status_id = '1';
        $serviceRequest->total_amount = '4500';
        $serviceRequest->save();

        $serviceRequest = new ServiceRequest();
        $serviceRequest->user_id = '2';
        $serviceRequest->admin_id = '1';
        $serviceRequest->cse_id = '3';
        $serviceRequest->technician_id = '3';
        $serviceRequest->category_id = '7';
        $serviceRequest->service_id = '1';
        $serviceRequest->job_reference = 'REF-330CB862';
        $serviceRequest->security_code = 'SEC-88AC1B19';
        $serviceRequest->service_request_status_id = '1';
        $serviceRequest->total_amount = '2500';
        $serviceRequest->save();

        $serviceRequest = new ServiceRequest();
        $serviceRequest->user_id = '2';
        $serviceRequest->admin_id = '1';
        $serviceRequest->cse_id = '3';
        $serviceRequest->technician_id = '3';
        $serviceRequest->category_id = '5';
        $serviceRequest->service_id = '3';
        $serviceRequest->job_reference = 'REF-27D2F0BE';
        $serviceRequest->security_code = 'SEC-88AC1B19';
        $serviceRequest->service_request_status_id = '1';
        $serviceRequest->total_amount = '3500';
        $serviceRequest->save();

    }
}
