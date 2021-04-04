<?php

namespace App\Http\Controllers\ServiceRequest;

use App\Http\Controllers\Controller;
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
        \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $serviceRequest_id, 2, $subStatus_id);
//        dd($invoice);
        return view('frontend.invoices.invoice')->with([
            'invoice' => $invoice
        ]);
    }

}
