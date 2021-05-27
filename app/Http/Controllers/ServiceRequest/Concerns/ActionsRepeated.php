<?php

namespace App\Http\Controllers\ServiceRequest\Concerns;

use App\Models\Rfq;
use App\Models\SubStatus;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceRequestReport;
use App\Models\ServiceRequestProgress;

class ActionsRepeated
{
    public $repeated_actions;
    // 

    /**
     * Handle repated Actions on a Service Request
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\ServiceRequest $service_request
     * 
     * @return array $repeated_actions
     */
    public static function handle(Request $request, ServiceRequest $service_request, array $repeated_actions)
    {
        // dd($request->add_comment, 'add_comment');
        // Handle Add Comment
        if ($request->filled('add_comment')) {
            array_push($repeated_actions, self::build_comment($request, $service_request));
        }

        // Handle RFQ
        if ($request->filled('intiate_rfq')) {
            array_push($repeated_actions, self::build_new_rfq($request, $service_request));
        }

        return $repeated_actions;
    }

    /**
     * Build Comment to be added to database
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function build_comment(Request $request, ServiceRequest $service_request)
    {
        $request->validate(['add_comment' => 'required|string']);
        // Each Key should match table names, value match accepted parameter in each table name stated
        $sub_status = SubStatus::where('uuid', 'ab43a32e-709e-4bf9-bba2-78828d2cfda9')->firstOrFail();
        return [
            'service_request_reports' => [
                'user_id'              => $request->user()->id,
                'service_request_id'   => $service_request->id,
                'stage'                 => ServiceRequestReport::STAGES[0],
                'type'                  => ServiceRequestReport::TYPES[2],
                'report'                => $request->input('add_comment'),
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
                'message'                   =>  $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' added comment to ' . $service_request->unique_id . ' Job',
            ]
        ];
    }

    /**
     * Build Comment to be added to database
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function build_new_rfq(Request $request, ServiceRequest $service_request)
    {
        // validate Request
        (array) $valid = $request->validate([
            'intiate_rfq'               => 'bail|string|in:yes,no',

            'manufacturer_name'         => 'bail|required|array',
            'manufacturer_name.*'       => 'required|string',

            'model_number'              => 'bail|required|array',
            'model_number.*'            => 'required|string',

            'component_name'            => 'bail|required|array',
            'component_name.*'          => 'required|string',

            'quantity'                  => 'bail|required|array',
            'quantity.*'                => 'required|string',

            'image'                     => 'bail|required|array',
            'image.*'                   => 'bail|required|image',

            'unit_of_measurement'       => 'bail|sometimes|array|nullable',
            'unit_of_measurement.*'     => 'nullable',

            'size'                      => 'bail|required|array',
            'size.*'                    => 'nullable',
        ]);


        // Each Key should match table names, value match accepted parameter in each table name stated
        $sub_status = SubStatus::where('uuid', '2df4da1e-6c07-402c-a316-0378d37e50a1')->firstOrFail();

        return [
            'rfqs' => [
                // save on rfqs table
                'issued_by'             => $request->user()->id,
                'service_request_id'    => $service_request->id,
                'type'                  => Rfq::TYPES[0],
                'rfq_batches' => $valid,
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
                'message'                   =>  $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' issued an RFQ for Service Request:' . $service_request->unique_id . ' Job',
            ]
        ];
    }
}
