<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Invoice;
use App\Models\Tax;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.invoices.index')->with([
            'invoices' => \App\Models\Invoice::latest('invoices.created_at')->get(),
        ]);
    }

    public function invoice($language, Invoice $invoice)
    {
        $get_fixMaster_royalty = Income::select('amount', 'percentage')->where('income_name', 'FixMaster Royalty')->first();
        $get_logistics = Income::select('amount', 'percentage')->where('income_name', 'Logistics Cost')->first();
        $get_taxes = Tax::select('percentage')->where('name', 'VAT')->first();
        $serviceCharge = $invoice->serviceRequest->service->service_charge;

        $tax = $get_taxes->percentage/100;
        $fixMaster_royalty_value = $get_fixMaster_royalty->percentage;
        $logistics_cost = $get_logistics->amount;
        $materials_cost = $invoice->materials_cost == null ? 0 : $invoice->materials_cost;
        $sub_total = $materials_cost + $invoice->labour_cost;

        $fixMasterRoyalty = '';

        $warrantyCost = '';
        $bookingCost = '';
        $tax_cost = '';
        $total_cost = '';

        if($invoice->invoice_type == 'Diagnostic Invoice')
        {
            $fixMasterRoyalty = $fixMaster_royalty_value * ( $serviceCharge );
            $tax_cost = $tax * ( $serviceCharge + $logistics_cost + $fixMasterRoyalty );
            $total_cost = $serviceCharge + $fixMasterRoyalty + $tax_cost + $logistics_cost;
        }
        else
        {
            $warrantyCost = 0.1 * ( $invoice->labour_cost + $materials_cost );
            $bookingCost = $invoice->serviceRequest->price->amount;
            $fixMasterRoyalty = $fixMaster_royalty_value * ( $invoice->labour_cost + $materials_cost + $logistics_cost );
            $tax_cost = $tax * $sub_total;
            $total_cost = $materials_cost + $invoice->labour_cost + $fixMasterRoyalty + $warrantyCost + $logistics_cost - $bookingCost - 1500 + $tax_cost;
        }

        return view('frontend.invoices.invoice')->with([
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
