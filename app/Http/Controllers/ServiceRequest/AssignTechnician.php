<?php

namespace App\Http\Controllers\ServiceRequest;

use Illuminate\Http\Request;
use App\Traits\findRecordWithUUID;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AssignTechnician extends Controller
{
    use findRecordWithUUID;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // dd($request->all());
        // validate Request
        (array) $valid = $this->validate($request, [
            'technician_user_id'  =>   'required|string|exists:technicians,user_id',
            'service_request_uuid' => 'required|uuid|exists:service_requests,uuid'
        ]);
        return $this->assignTechnician($valid);
    }

    /**
     * Update neccesary tables to assign the Technician to a service
     *
     * @param  array  $valid
     * @return \Illuminate\Http\Response
     */
    protected function assignTechnician(array $valid)
    {
        (bool) $registred = false;
        // Run DB Transaction to update all necessary records
        DB::transaction(function () use ($valid, &$registred) {
            // 1. Find the Service Request ID from the UUID
            $serviceRequest = $this->findUsingUUID('service_requests', $valid['service_request_uuid']);
            // 2. Find the status for Assigning technician record
            // $status = 
            
            // store in the service_request_assigned
            \App\Models\ServiceRequestAssigned::assignUserOnServiceRequest($valid['technician_user_id'], $serviceRequest->id);
            // store in the service_request_progresses
            // \App\Models\ServiceRequestProgress::storeProgress($valid['technician_user_id'], $serviceRequest->id);
            // store in the activity log
        });
        return $registred;

        // notify the technicain in Email and In-app notification
    }
}
