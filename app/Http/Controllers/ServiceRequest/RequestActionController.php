<?php

namespace App\Http\Controllers\ServiceRequest;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ServiceRequest\Concerns\StoreInDatabase;

class RequestActionController extends Controller
{
    use StoreInDatabase;

    public $to_be_stored;
    /**
     * Handle the incoming request for service request action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $locale
     * @param  \App\Models\ServiceRequest $service_request
     * 
     * @return \Illuminate\Http\Response
     */
    public function incoming(Request $request, string $locale, ServiceRequest $service_request)
    {
        (array)$to_be_stored = [];

        if ($request->hasAny(['add_comment','qa_user_uuid', 'add_technician_user_uuid'])) {
            $action = \App\Http\Controllers\ServiceRequest\Concerns\ActionsRepeated::handle($request, $service_request, $to_be_stored);
            $to_be_stored = $action;
        }

        if($request->filled('technician_user_uuid')){
            $action = \App\Http\Controllers\ServiceRequest\Concerns\AssignTechnician::handle($request, $service_request, $to_be_stored);
            $to_be_stored = $action;
        }

        if($request->filled('preferred_time')){
            $action = \App\Http\Controllers\ServiceRequest\Concerns\SchedulingDate::handle($request, $service_request, $to_be_stored);
            $to_be_stored = $action;
        }

        if($request->filled('category_uuid')){
            $action = \App\Http\Controllers\ServiceRequest\Concerns\Categorization::handle($request, $service_request, $to_be_stored);
            $to_be_stored = $action;
        }

        if($request->filled(['estimated_work_hours','root_cause', 'intiate_rfq', 'intiate_trf', ])){
            $action = \App\Http\Controllers\ServiceRequest\Concerns\Invoicebuilder::handle($request, $service_request, $to_be_stored);
            $to_be_stored = $action;
        }

        // call the storage 
        return !empty($to_be_stored)
            ? ($this->saveAction($to_be_stored)
                ? back()->with('success', 'Project Progress updated Successfully!!')
                : back()->with('error', 'Error occured while updating project progress'))
            : back()->with('error', 'Error Generating Request Content');
    }
}
