<?php

namespace App\Http\Controllers\ServiceRequest\Concerns;

use App\Models\SubStatus;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;

class MaterialAcceptance
{
    public $actionable;

    /**
     * Handle Material Acceptance 
     * 
     * @param  \Illuminate\Http\Request     $request
     * @param  \App\Models\ServiceRequest   $service_request
     * 
     * @return array $actionable
     */
    public static function handle(Request $request, ServiceRequest $service_request, array $actionable)
    {
        // Handle Material Status
        if ($request->filled('material_status')) {
            array_push($actionable, self::update_material_status($request, $service_request));
        }

        return $actionable;
    }

    /**
     * Update Material Acceptance
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function update_material_status(Request $request, ServiceRequest $service_request)
    {
        // validate Request
        (array) $valid = $request->validate([
            'material_status'               =>  'bail|string|in:Awaiting,Shipped,Delivered',
        ]);

        dd($valid);

        // Updating rfq_supplier_dispatches to $valid['material_status']

        // Each Key should match table names, value match accepted parameter in each table name stated
        // $sub_status = SubStatus::where('uuid', '1abe702c-e6b1-422f-9145-810394f92e1d')->firstOrFail();
        $service_request->rfq->loadMissing(['rfqBatches.supplierInvoiceBatches', 'rfqSupplierInvoice.supplierDispatch']);
        return [
            'rfq_supplier_dispatches' => [
                'cse_status'          => $valid['material_status'],
            ],
            // 'service_request_progresses' => [
            //     'user_id'              => $request->user()->id,
            //     'service_request_id'   => $service_request->id,
            //     'status_id'            => $sub_status->status_id,
            //     'sub_status_id'        => $sub_status->id,
            // ],
            'log' => [
                'type'                      =>  'request',
                'severity'                  =>  'informational',
                'action_url'                =>  \Illuminate\Support\Facades\Route::currentRouteAction(),
                'message'                   =>  $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' updated of the status of the Supplier Dispatch' . $service_request['rfq']['rfqSupplierInvoice']['supplierDispatch']['unique_id'] . ' for Service Request:' . $service_request->unique_id . ' Job',
            ]
        ];
    }
}
