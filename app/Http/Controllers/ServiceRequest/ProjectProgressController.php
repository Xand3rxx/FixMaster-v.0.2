<?php

namespace App\Http\Controllers\ServiceRequest;

use App\Traits\Loggable;
use Illuminate\Http\Request;
use App\Traits\findRecordWithUUID;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class ProjectProgressController extends Controller
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
            'sub_status_uuid'         =>   'bail|required|string|uuid',
            'service_request_uuid'  => 'required|uuid|exists:service_requests,uuid'
        ]);
        return $this->updateProjectProgress($valid, $request->user()) == true
            ? back()->with('success', 'Project Progress successfully!!')
            : back()->with('error', 'Error occured while updating project progress');
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
    protected function updateProjectProgress(array $valid, \App\Models\User $user)
    {
        (bool) $registred = false;
        // service request progressess
        // activity log
        // 1. Find the Service Request ID from the UUID
        $serviceRequest = $this->findUsingUUID('service_requests', $valid['service_request_uuid']);
        //  2. Find the Substatus selected 
        $substatus = \App\Models\SubStatus::where('uuid', $valid['sub_status_uuid'])->firstOrFail();

        // Run DB Transaction to update all necessary records
        DB::transaction(function () use ($user, $serviceRequest, $substatus, &$registred) {
            // store in the service_request_progresses
            \App\Models\ServiceRequestProgress::storeProgress($user->id, $serviceRequest->id, $substatus->status_id, $substatus->id);
            // store in the activity log
            $this->log('request', 'Informational', Route::currentRouteAction(), $user->account->last_name . ' ' . $user->account->first_name . ' ' . $substatus->name . ' for (' . $serviceRequest->unique_id . ') Job.');
            // notify the technicain in Email and In-app notification

            // update registered to be true
            $registred = true;
        });
        return $registred;
    }
}
