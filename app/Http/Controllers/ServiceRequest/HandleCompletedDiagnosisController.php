<?php

namespace App\Http\Controllers\ServiceRequest;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Tax;
use Illuminate\Http\Request;

use App\Traits\Invoices;

class HandleCompletedDiagnosisController extends Controller
{
    use Invoices;
    /**
     * Generate Diagnosis Invoice
     *
     * @param  int  $serviceRequest_id
     * @param  int  $subStatus_id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function generateDiagnosisInvoice(int $serviceRequest_id, int $subStatus_id)
    {
        $invoice = $this->diagnosticInvoice($serviceRequest_id);
        $get_fixMaster_royalty = Income::select('amount', 'percentage')->where('income_name', 'FixMaster Royalty')->first();
        $get_logistics = Income::select('amount', 'percentage')->where('income_name', 'Logistics Cost')->first();
        $get_taxes = Tax::select('percentage')->where('name', 'VAT')->first();
        $serviceCharge = $invoice->serviceRequest->service->service_charge;

        $tax = $get_taxes->percentage/100;
        $fixMaster_royalty_value = $get_fixMaster_royalty->percentage;
        $logistics_cost = $get_logistics->amount;

        $fixMasterRoyalty = $fixMaster_royalty_value * ( $serviceCharge );
        $tax_cost = $tax * ( $serviceCharge + $logistics_cost + $fixMasterRoyalty );
        $total_cost = $serviceCharge + $fixMasterRoyalty + $tax_cost + $logistics_cost;


        \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $serviceRequest_id, 2, $subStatus_id);
        return view('frontend.invoices.invoice')->with([
            'invoice' => $invoice,
            'fixmaster_royalty' => $fixMasterRoyalty,
            'get_fixMaster_royalty' => $get_fixMaster_royalty,
            'taxes' => $tax_cost,
            'logistics' => $logistics_cost,
            'total_cost' => $total_cost
        ]);
    }

}
