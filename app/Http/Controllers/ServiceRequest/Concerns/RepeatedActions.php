<?php

namespace App\Http\Controllers\ServiceRequest\Concerns;

use App\Models\SubStatus;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceRequestReport;
use App\Models\ServiceRequestProgress;

class RepeatedActions
{
    public $repeated_actions;
    protected $service_request;
    protected $request;
    protected $validated;
    protected $comment;

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
     * @return array $repeated_actions
     */
    public function handle()
    {
        (array)$repeated_actions = [];
        if ($this->request->has('add_comment')) {
            $repeated_actions = array_merge($repeated_actions, $this->build_comment());
        }

        return $repeated_actions;
        // return $this->request->input('add_comment') ? $this->build_comment() : null;
    }

    /**
     * CSE Added Comments
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected function build_comment()
    {
        $this->request->validate(['add_cooment' => 'required|string']);
        // Each Key should match table names, value match accepted parameter in each table name stated
        $sub_status = SubStatus::where('uuid', 'ab43a32e-709e-4bf9-bba2-78828d2cfda9')->firstOrFail();
        return [
            'service_request_reports' => [
                'user_id'              => $this->request->user()->id,
                'service_request_id'   => $this->service_request->id,
                'stage'                 => ServiceRequestReport::STAGES[0],
                'type'                  => ServiceRequestReport::TYPES[2],
                'report'                => $this->request->input('add_cooment'),
            ],
            'service_request_progresses' => [
                'user_id'              => $this->request->user()->id,
                'service_request_id'   => $this->service_request->id,
                'status_id'            => $sub_status->status_id,
                'sub_status_id'        => $sub_status->id,
            ],
            'log' => [
                'type'                      =>  'request',
                'severity'                  =>  'informational',
                'action_url'                =>  \Illuminate\Support\Facades\Route::currentRouteAction(),
                'message'                   =>  $this->request->user()->account->last_name . ' ' . $this->request->user()->account->first_name . ' added comment to ' . $this->service_request->unique_id . ' Job',
            ]
        ];
    }
}
