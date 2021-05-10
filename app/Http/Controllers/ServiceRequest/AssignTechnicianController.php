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
        $this->validate($request, [
            'technician_user_uuid'  =>   'required|uuid|exists:users,uuid',
            'service_request_uuid' =>    'required|uuid|exists:service_requests,uuid'
        ]);
        return $this->assignTechnician($request) == true
            ? back()->with('success', 'Technician Assigned successfully!!')
            : back()->with('error', 'Error occured while assigning a technician');
    }

    public function handleAdditionalTechnician(Request $request)
    {
        return $this->assignTechnician($request);
    }

    /**
     * Update neccesary tables to assign the Technician to a service
     *
     * @param  \Illuminate\Http\Request     $request
     * 
     * @return \Illuminate\Http\Response
     */
    protected function assignTechnician(Request $request)
    {
        (bool) $registred = false;
        // 1. Find the Service Request ID from the UUID
        $serviceRequest = \App\Models\ServiceRequest::where('uuid', $request['service_request_uuid'])->with('users')->firstOrFail();
        // 2. Find the technician
        $technician = \App\Models\User::where('uuid', $request['technician_user_uuid'])->with('account')->firstOrFail();
        // 3. Confirm if Technician is already assigned
        if (collect($serviceRequest['users']->first(function ($user) use ($technician) {
            return $user->id == $technician->id;
        }))->isNotEmpty()) {
            return back()->with('error', $technician['account']['last_name'] . ' ' . $technician['account']['first_name'] . ' is already assigned to this Service Request');
        }
        // 4. Find the status for Assigning technician record
        $status = \App\Models\SubStatus::where('uuid', '1faffcc3-7404-4fad-87a7-97161d3b8546')->firstOrFail();

        // Run DB Transaction to update all necessary records after confirmation Technician is not already on the Service Request
        DB::transaction(function () use ($request, $serviceRequest, $technician, $status, &$registred) {
            // When preferred time is set
            $request->whenFilled('preferred_time', function () use ($request, $serviceRequest) {
                $serviceRequest->update(['preferred_time' => $request['preferred_time']]);
                $status = \App\Models\SubStatus::where('uuid', 'd258667a-1953-4c66-b746-d0c40de7189d')->firstOrFail();
                \App\Models\ServiceRequestProgress::storeProgress($request->user()->id, $serviceRequest->id, 2, $status->id);
            });

            // 1. Update the Service Request Status to Ongoing
            $serviceRequest->update(['status_id' => $status->status_id]);
            // 2. store in the service_request_assigned
            \App\Models\ServiceRequestAssigned::assignUserOnServiceRequest($technician->id, $serviceRequest->id);
            // 3. store in the service_request_progresses
            \App\Models\ServiceRequestProgress::storeProgress($request->user()->id, $serviceRequest->id, 2, $status->id);
            // 4. store in the activity log
            $this->log('request', 'Informational', Route::currentRouteAction(), $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' assigned ' . $technician['account']['last_name'] . ' ' . $technician['account']['first_name'] . ' (Technician) to ' . $serviceRequest->unique_id . ' Job.');
            // 5. notify the technicain in Email and In-app notification

            // 6. update registered to be true
            $registred = true;
        });
        return $registred;
    }
}
