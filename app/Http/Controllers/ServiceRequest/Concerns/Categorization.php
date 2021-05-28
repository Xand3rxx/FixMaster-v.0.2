<?php

namespace App\Http\Controllers\ServiceRequest\Concerns;

use App\Models\SubStatus;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;

class Categorization
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
        array_push($actionable, self::build_categorization($request, $service_request));
        return $actionable;
    }

    /**
     * Build Scheduling of Date for Client
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function build_categorization(Request $request, ServiceRequest $service_request)
    {
        // dd($request->all(), 'sub_service');
        (array) $valid = $request->validate([
            'category_uuid'         => 'required|uuid',
            'service_uuid'          => 'required|uuid',
            'sub_service_uuid'      => 'required|uuid|exists:sub_services,uuid',
            'root_cause'            => 'required|string',
            'other_comments'        => 'nullable',
        ]);
        dd($valid, $request->all(), 'sub_service');
        // Each Key should match table names, value match accepted parameter in each table name stated
        $sub_status = SubStatus::where('uuid', '22821883-fc00-4366-9c29-c7360b7c2efc')->firstOrFail();
        return [
            'service_request_table' => [
                'service_request'   => $service_request,
                'preferred_time'              => $request->input('preferred_time'),
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
    }
}
