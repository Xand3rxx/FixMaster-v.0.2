<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Tax;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\Rfq;
use App\Models\RfqBatch;
use App\Models\ServiceRequest;
use App\Models\RfqSupplier;

use App\Traits\Invoices;

class SimulationController extends Controller
{
    use Invoices;

    public function diagnosticSimulation()
    {
        $serviceRequests = ServiceRequest::all();
        $data = [
            'serviceRequests' => $serviceRequests,
        ];
        return view('admin.simulation.diagnostic', $data);
    }

    public function endService($language, ServiceRequest $serviceRequest)
    {
        $client_id = $serviceRequest->client_id;
        $service_request_id = $serviceRequest->id;
        $invoice_type = 'Diagnostic Invoice';
        $hours_spent = 1;
        $total = $serviceRequest->total_amount;
        $amount_due = $serviceRequest->total_amount;
        $amount_paid = $serviceRequest->total_amount;
        $status = '1';

        $this->diagnosticInvoice($client_id, $service_request_id, $invoice_type, $total, $amount_due, $amount_paid, $hours_spent, $status);
        return redirect()->route('admin.rfq', app()->getLocale());
    }

    public function completeService($language, ServiceRequest $serviceRequest)
    {
        $client_id = $serviceRequest->client_id;
        $service_request_id = $serviceRequest->id;
        $rfq_id = isset($serviceRequest->rfq->id) ? $serviceRequest->rfq->id : null ;
        $invoice_type = 'Completion Invoice';
        $materials_cost = isset($serviceRequest->rfq->id) ? $serviceRequest->rfq->total_amount : 0;
        $hours_spent = '2';
        $status = '1';


        $this->completedServiceInvoice($client_id, $service_request_id, $rfq_id, $invoice_type, $materials_cost, $hours_spent, $status);

        return redirect()->route('admin.rfq', app()->getLocale());
    }

    public function rfqSimulation()
    {
        $serviceRequests = ServiceRequest::all();
        $data = [
            'serviceRequests' => $serviceRequests,
        ];
        return view('admin.simulation.rfq', $data);
    }

    public function rfqDetailsSimulation($language, ServiceRequest $serviceRequest)
    {
        $requestDetail = ServiceRequest::findOrFail($serviceRequest->id);

        $data = [
            'requestDetail'         =>  $requestDetail,
            'serviceRequests'       =>  $serviceRequest
        ];

        return view('admin.simulation.request_ongoing_details', $data);
    }

    public function simulateOngoingProcess($language, Request $request)
    {
        $clientId = $request->input('client_id');
        $serviceRequestId = $request->input('service_request_id');

        if(!empty($request->input('rfq_id'))){

            //Validate input fields for RFQ update
            $request->validate([
                'name'              =>  'required',
                'devlivery_fee'     =>  'required',
                'delivery_time'     =>  'required',
                'amount'            =>  'required',
            ]);

            // return $request->amount;
            $rfId =  $request->input('rfq_id');
            $totalAmount = 0;

            RfqSupplier::create([
                'rfq_id'            =>  $rfId,
                'supplier_id'       =>  1,
                'devlivery_fee'     =>  $request->input('devlivery_fee'),
                'delivery_time'     =>  \Carbon\Carbon::parse($request->input('delivery_time'), 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa'),
            ]);

            //Update amount for each entry on `rfq_batches` table for a RFQ Batch record
            foreach ($request->amount as $item => $value){
                RfqBatch::where('rfq_id', $rfId)->update([
                    'amount'    =>  $request->amount[$item],
                ]);

                $totalAmount += ($request->amount[$item] * $request->quantity[$item]);
            }

            //Update total_amount for RFQ in `rfqs` table
            Rfq::where('id', $rfId)->update([
                'total_amount'  =>  $totalAmount,
                'status'            =>  'Awaiting', //Status is set to `Awaiting Client's paymemt`
            ]);

//            (int $user_id, int $service_request_id, int $rfq_id, string $invoice_type, int $total_amount, int $amount_due, int $amount_paid, string  $status)

            $this->supplierInvoice($clientId, $serviceRequestId, $rfId, 'Supplier Invoice', $totalAmount, $totalAmount, 0, 1);

            return redirect()->route('admin.rfq', app()->getLocale());

        }

        if($request->input('intiate_rfq') == 'yes') {

            //Create RFQ Batch record on `rfqs` table
            $createRFQ = Rfq::create([
                'uuid' => Str::uuid('uuid'),
                'unique_id' => 'RFQ-' . strtoupper(substr(md5(time()), 0, 8)),
                'issued_by' => Auth::id(),
                'service_request_id' => $serviceRequestId,
                'client_id' => $clientId,
                'total_amount' => 0,
                'updated_at' => null,
            ]);

            $client_id = $clientId;
            $service_request_id = $serviceRequestId;
            $rfq_id = $createRFQ->id;
            $invoice_type = 'RFQ Invoice';
            $status = '1';


            $this->rfqInvoice($client_id, $service_request_id, $rfq_id, $invoice_type, $status);


            //Create entries on `rfq_batches` table for a single RFQ Batch record
            foreach ($request->component_name as $item => $value) {
                RfqBatch::create([
                    'rfq_id' => $createRFQ->id,
                    'component_name' => $request->component_name[$item],
                    'model_number' => $request->model_number[$item],
                    'quantity' => $request->quantity[$item],
                ]);
            }

            return redirect()->route('admin.rfq', app()->getLocale());
        }
    }

    public function invoice($language, Invoice $invoice)
    {
        $get_fixMaster_royalty = Income::select('amount', 'percentage')->where('income_name', 'FixMaster Royalty')->first();
        $get_logistics = Income::select('amount', 'percentage')->where('income_name', 'Logistics Cost')->first();
        $get_taxes = Tax::select('percentage')->where('name', 'VAT')->first();

        $tax = $get_taxes->percentage/100;
        $fixMaster_royalty_value = $get_fixMaster_royalty->percentage;
        $logistics_cost = $get_logistics->amount;
        $materials_cost = $invoice->materials_cost == null ? 0 : $invoice->materials_cost;
        $sub_total = $materials_cost + $invoice->labour_cost;

        $fixMasterRoyalty = $fixMaster_royalty_value * ( $invoice->labour_cost + $materials_cost + $logistics_cost );
        $warrantyCost = 0.1 * ( $invoice->labour_cost + $materials_cost );
        $bookingCost = $invoice->serviceRequest->price->amount;

        $tax_cost = $tax * $sub_total;
        $total_cost = $invoice->total_amount + $fixMasterRoyalty + $tax_cost + $warrantyCost + $logistics_cost - $bookingCost - 1500;

        return view('admin.invoices.invoice')->with([
            'invoice' => $invoice,
            'fixmaster_royalty' => $fixMasterRoyalty,
            'get_fixMaster_royalty' => $get_fixMaster_royalty,
            'taxes' => $tax_cost,
            'logistics' => $logistics_cost,
            'warranty' => $warrantyCost,
            'total_cost' => $total_cost
        ]);
    }
}
