<?php

namespace App\Http\Controllers\ServiceRequest;

use App\Models\Income;
use App\Models\SubService;
use App\Models\Tax;
use App\Traits\Invoices;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Traits\Loggable;
use Illuminate\Support\Facades\Route;

class HandleCompletedDiagnosisController extends Controller
{
    use Invoices, Loggable;
    /**
     * Generate Diagnosis Invoice
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  \App\Models\ServiceRequest   $serviceRequest
     * @param  \App\Models\SubStatus        $substatus
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function generateDiagnosisInvoice(Request $request, \App\Models\ServiceRequest $serviceRequest, \App\Models\SubStatus $substatus)
    {
        // validate Request
        (array) $valid = $this->validate($request, [
            'estimated_work_hours'      => 'bail|required|numeric',
            'sub_service_uuid'          => 'bail|required|string|uuid',

            'intiate_rfq'               => 'bail|string|in:yes,no',
            'component_name'            => 'bail|sometimes|required_unless:intiate_rfq,no|array',
            'component_name.*'          => 'bail|sometimes|required_unless:intiate_rfq,no|nullable',
            'model_number'              => 'bail|sometimes|required_unless:intiate_rfq,no|array',
            'model_number.*'            => 'bail|sometimes|required_unless:intiate_rfq,no|nullable',
            'quantity'                  => 'bail|sometimes|required_unless:intiate_rfq,no|array',
            'quantity.*'                => 'bail|sometimes|required_unless:intiate_rfq,no|nullable',

            'intiate_trf'               =>  'bail|string|in:yes,no',
            'tool_id'                   =>  'bail|sometimes|required_unless:intiate_trf,no|array',
            'tool_id.*'                 =>  'bail|sometimes|required_unless:intiate_rfq,no|nullable',
            'tool_quantity'             =>  'bail|sometimes|required_unless:intiate_trf,no|array',
            'tool_quantity.*'           =>  'bail|sometimes|required_unless:intiate_rfq,no|nullable',

        ]);


        if ($request['intiate_rfq'] == 'yes') {
            // save to 1. rfqs 2. rfq_batches
            \Illuminate\Support\Facades\DB::transaction(function () use ($valid, $serviceRequest, &$rfq) {
                // save on rfqs table
                $rfq = \App\Models\Rfq::create([
                    'issued_by' => auth()->user()->id,
                    'client_id' => $serviceRequest->client_id,
                    'service_request_id'    => $serviceRequest->id,
                ]);
                // save each of the component name on the rfqbatch table
                foreach ($valid['component_name'] as $key => $component_name) {
                    \App\Models\RfqBatch::create([
                        'rfq_id'           => $rfq->id,
                        'component_name'    => $component_name,
                        'model_number'      => $valid['model_number'][$key],
                        'quantity'          => $valid['quantity'][$key],
                        'amount'            => 0.00
                    ]);
                }
                $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ') Job.');
            });
        }

        if ($request['intiate_trf'] == 'yes') {
            // save to 1. tool_requests  2. tool_request_batches
            \Illuminate\Support\Facades\DB::transaction(function () use ($valid, $serviceRequest) {
                // save on the tools requests table
                $toolsRequest = \App\Models\ToolRequest::create([
                    'requested_by' => auth()->user()->id,
                    'client_id' => $serviceRequest->client_id,
                    'service_request_id'    => $serviceRequest->id,
                ]);
                // save each of the component name on the tool_request_batches table
                foreach ($valid['tool_id'] as $key => $tool_id) {
                    \App\Models\ToolRequestBatch::create([
                        'tool_request_id'  => $toolsRequest->id,
                        'tool_id'           => $tool_id,
                        'quantity'          => $valid['tool_quantity'][$key],
                    ]);
                }
                $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ') Job.');
            });
        }


        // Check if New Technician is assigned
        // store in the service_request_progresses
        // \App\Models\ServiceRequestProgress::storeProgress($user->id, $serviceRequest->id, $substatus->status_id, $substatus->id);
        // store in the activity log
        // $this->log('request', 'Informational', Route::currentRouteAction(), $user->account->last_name . ' ' . $user->account->first_name . ' ' . $substatus->name . ' for (' . $serviceRequest->unique_id . ') Job.');
        // $serviceRequest_id = $serviceRequest->id;
        // $invoice = $this->diagnosticInvoice($serviceRequest_id);
        $subServiceId = SubService::select('id')->where('uuid', $request->sub_service_uuid)->first();

        $rfq = $request['intiate_rfq'] == 'yes' ? $rfq->id : null;

        $invoice = $this->diagnosisInvoice($serviceRequest->id, $rfq, $subServiceId->id, $request->estimated_work_hours);

        $get_fixMaster_royalty = Income::select('amount', 'percentage')->where('income_name', 'FixMaster Royalty')->first();
        $get_logistics = Income::select('amount', 'percentage')->where('income_name', 'Logistics Cost')->first();
        $get_taxes = Tax::select('percentage')->where('name', 'VAT')->first();
        $serviceCharge = $invoice->serviceRequest->service->service_charge;

        $tax = $get_taxes->percentage / 100;
        $fixMaster_royalty_value = $get_fixMaster_royalty->percentage;
        $logistics_cost = $get_logistics->amount;

        $fixMasterRoyalty = $fixMaster_royalty_value * ($serviceCharge);
        $tax_cost = $tax * ($serviceCharge + $logistics_cost + $fixMasterRoyalty);
        $total_cost = $serviceCharge + $fixMasterRoyalty + $tax_cost + $logistics_cost;


        // Saving completed Diagnosis
        \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $serviceRequest->id, 2, $substatus->id);

        // Activity Log

        // 1. Service progressess
        $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name . ' ' . $substatus->name . ' for (' . $serviceRequest->unique_id . ') Job.');

        // store in the activity log

        return view('frontend.invoices.invoice')->with([
            'invoice' => $invoice,
            'rfqExists' => $invoice->rfq_id,
            'serviceRequestID' => $serviceRequest->id,
            'serviceRequestUUID' => $serviceRequest->uuid,
            'fixmaster_royalty' => $fixMasterRoyalty,
            'get_fixMaster_royalty' => $get_fixMaster_royalty,
            'taxes' => $tax_cost,
            'logistics' => $logistics_cost,
            'total_cost' => $total_cost
        ]);
    }
}
