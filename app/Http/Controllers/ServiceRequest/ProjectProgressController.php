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
        $this->validate($request, [
            'sub_status_uuid'       =>  'bail|required|string|uuid',
            'service_request_uuid'  =>  'required|string|uuid|exists:service_requests,uuid',
            'technician_user_uuid'  =>  'sometimes|nullable|uuid|exists:users,uuid',
        ]);

        $request->whenFilled('technician_user_uuid', function () use ($request) {
            $assignTechnician =  new AssignTechnicianController();
            $assignTechnician->handleAdditionalTechnician($request);
        });

        return $this->updateProjectProgress($request);
    }

    /**
     * Update the Project progress 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function updateProjectProgress(Request $request)
    {
        // 1. Find the Service Request ID from the UUID
        // $serviceRequest = $this->findUsingUUID('service_requests', $valid['service_request_uuid']);
        $serviceRequest = \App\Models\ServiceRequest::where('uuid', $request['service_request_uuid'])->firstOrFail();
        //  2. Find the Substatus selected 
        $substatus = \App\Models\SubStatus::where('uuid', $request['sub_status_uuid'])->firstOrFail();
        // Check if Completed diagnosis, then transfer to Isaac Controller
        if ($substatus->phase === 8) {
            return $this->handleCompletedDiagnosis($request, $serviceRequest, $substatus);
        }
        return $this->updateDatabase($request->user(), $serviceRequest, $substatus);
    }

    /**
     * Handle Completed Diagnosis
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  \App\Models\ServiceRequest   $serviceRequest
     * @param  \App\Models\SubStatus        $substatus
     * 
     * 
     * @return \Illuminate\Http\Response
     */
    protected function handleCompletedDiagnosis(Request  $request, \App\Models\ServiceRequest $serviceRequest, \App\Models\SubStatus $substatus)
    {
        $completedDiagnosis =  new HandleCompletedDiagnosisController();
        return $completedDiagnosis->generateDiagnosisInvoice($request, $serviceRequest, $substatus);
    }

    /**
     * Handle Completed Diagnosis
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\ServiceRequest $serviceRequest
     * @param  \App\Models\SubStatus $substatus
     * 
     * @return \Illuminate\Http\Response
     */
    protected function updateDatabase(\App\Models\User $user, \App\Models\ServiceRequest $serviceRequest, \App\Models\SubStatus $substatus)
    {
        // Run DB Transaction to update all necessary records
        (bool) $registred = false;

        DB::transaction(function () use ($user, $serviceRequest, $substatus, &$registred) {
            // store in the service_request_progresses
            \App\Models\ServiceRequestProgress::storeProgress($user->id, $serviceRequest->id, $substatus->status_id, $substatus->id);
            // store in the activity log
            $this->log('request', 'Informational', Route::currentRouteAction(), $user->account->last_name . ' ' . $user->account->first_name . ' ' . $substatus->name . ' for (' . $serviceRequest->unique_id . ') Job.');
            // notify the technicain in Email and In-app notification
            // $message = new \App\Http\Controllers\Messaging\MessageController();

            // update registered to be true
            $registred = true;
        });
        return $registred == true
            ? back()->with('success', 'Project Progress successfully!!')
            : back()->with('error', 'Error occured while updating project progress');
    }
}
