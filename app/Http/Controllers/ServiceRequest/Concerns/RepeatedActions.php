<?php

namespace App\Http\Controllers\ServiceRequest\Concerns;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceRequestProgress;
use App\Models\ServiceRequestReport;

class RepeatedActions
{
    protected $service_request;
    protected $request;
    protected $validated;

    /**
     * Handle repated Actions on a Service Request
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\ServiceRequest $service_request
     * 
     * @return void
     */
    public function __construct(Request $request, ServiceRequest $service_request)
    {
        $this->request = $request;
        $this->service_request = $service_request;
    }

    /**
     * Handle repated Actions on a Service Request
     * 
     * @return bool
     */
    public function handle()
    {
        $this->request->input('add_comment') ? $this->comment() : null;
        // return back()->with('error', (string)$canAcceptJob[1]);
    }

    /**
     * Verify if CSE Can Accept Job.
     * 
     * @return array $response
     */
    protected function comment()
    {
        (bool) $registred = false;
        $validated = $this->request->validate(['add_cooment' => 'required|string']);
        // 
        // Run DB Transaction to update all necessary records after confirmation Technician is not already on the Service Request
        DB::transaction(function () use (&$registred) {
            // Add Comment Substatus
            // Find the SubStatus for ADDING COMMENT
            $sub_status = \App\Models\SubStatus::where('uuid', 'ab43a32e-709e-4bf9-bba2-78828d2cfda9')->firstOrFail();
            // Update service_request_reports 
            ServiceRequestReport::create([]);
            // Update service_request_progresses
            ServiceRequestProgress::storeProgress($this->request->user()->id, $this->service_request->id, $sub_status->status_id, $sub_status->id);
            // 6. update registered to be true
            $registred = true;
        });
        return $registred;
    }
}
