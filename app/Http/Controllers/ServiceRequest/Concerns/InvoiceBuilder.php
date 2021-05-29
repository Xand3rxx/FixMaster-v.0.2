<?php

namespace App\Http\Controllers\ServiceRequest\Concerns;

use App\Models\Service;
use App\Models\SubStatus;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestReport;

class InvoiceBuilder
{
    public $actionable;

    /**
     * Handle scheduling of date
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\ServiceRequest $service_request
     * 
     * @return array $actionable
     */
    public static function handle(Request $request, ServiceRequest $service_request, array $actionable)
    {
        array_push($actionable, self::build_invoice($request, $service_request));
        return $actionable;
    }

    /**
     * Build Scheduling of Date for Client
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function build_invoice(Request $request, ServiceRequest $service_request)
    {
        try {
            (array) $valid = $request->validate([
                'estimated_work_hours'  => 'required|numeric',
                'quantity'              => 'required|array',
                'quantity.*'            => 'sometimes',
                'other_comments'        => 'nullable',
            ]);
        } catch (\Throwable $th) {
           dd($th);
        }

        dd($request->all(), 'invoice');

        // Each Key should match table names, value match accepted parameter in each table name stated
        $sub_status = SubStatus::where('uuid', 'f95c31c6-6667-4a64-bee3-8aa4b5b943d3')->firstOrFail();
        $service = Service::where('uuid', $valid['service_uuid'])->firstOrFail();
        $requiredArray = [
            'service_request_table' => [
                'service_request'   => $service_request,
                'service_id'        => $service->id,
                'sub_services'      => $valid['sub_service_uuid']
            ],
            'service_request_progresses' => [
                'user_id'              => $request->user()->id,
                'service_request_id'   => $service_request->id,
                'status_id'            => $sub_status->status_id,
                'sub_status_id'        => $sub_status->id,
            ],
            'log' => [
                'type'                      =>  'request',
                'severity'                  =>  'informational',
                'action_url'                =>  \Illuminate\Support\Facades\Route::currentRouteAction(),
                'message'                   =>  $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' scheduled date for client on Service Request:' . $service_request->unique_id . ' Job',
            ]
        ];
        if ($request->filled('other_comments')) {
            $otherComments = [
                'service_request_reports' => [
                    'user_id'              => $request->user()->id,
                    'service_request_id'   => $service_request->id,
                    'stage'                 => ServiceRequestReport::STAGES[0],
                    'type'                  => ServiceRequestReport::TYPES[2],
                    'report'                => $request->input('other_comments'),
                ]
            ];
            $requiredArray = array_merge($requiredArray, $otherComments);
        }
        return  $requiredArray;
    }
}
