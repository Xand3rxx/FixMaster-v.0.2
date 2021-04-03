<?php

namespace App\Http\Controllers\ServiceRequest;

use App\Traits\Loggable;
use Illuminate\Http\Request;
use App\Traits\findRecordWithUUID;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class AssignTechnicianController extends Controller
{
    use findRecordWithUUID, Loggable;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // validate Request
        (array) $valid = $this->validate($request, [
            'technician_user_id'  =>   'required|string|exists:technicians,user_id',
            'service_request_uuid' => 'required|uuid|exists:service_requests,uuid'
        ]);
        return $this->assignTechnician($valid, $request->user()) == true
            ? back()->with('success', 'Technician Assigned successfully!!')
            : back()->with('error', 'Error occured while assigning a technician');
    }

    /**
     * Update neccesary tables to assign the Technician to a service
     *
     * @param  array  $valid
     * @param  \App\Models\User $user
     * 
     * 
     * @return \Illuminate\Http\Response
     */
    protected function assignTechnician(array $valid, \App\Models\User $user)
    {
        (bool) $registred = false;
        // Run DB Transaction to update all necessary records
        DB::transaction(function () use ($valid, $user, &$registred) {
            // 1. Find the Service Request ID from the UUID
            $serviceRequest = $this->findUsingUUID('service_requests', $valid['service_request_uuid']);
            // 2. Find the status for Assigning technician record
            $status = \App\Models\SubStatus::where('name', 'Assigned a Technician')->firstOrFail();
            // 3. Find the technician
            $technician = \App\Models\User::where('id', $valid['technician_user_id'])->with('account')->firstOrFail();
            // store in the service_request_assigned
            \App\Models\ServiceRequestAssigned::assignUserOnServiceRequest($valid['technician_user_id'], $serviceRequest->id);
            // store in the service_request_progresses
            \App\Models\ServiceRequestProgress::storeProgress($valid['technician_user_id'], $serviceRequest->id, $status->id);
            // store in the activity log
            $this->log('request', 'Informational', Route::currentRouteAction(), $user->account->last_name . ' ' . $user->account->first_name . ' assigned ' . $technician['account']['last_name'] . ' ' . $technician['account']['first_name'] . ' (Technician) to ' . $serviceRequest->unique_id . ' Job.');
            // notify the technicain in Email and In-app notification

            // update registered to be true
            $registred = true;
        });
        return $registred;
    }
}
