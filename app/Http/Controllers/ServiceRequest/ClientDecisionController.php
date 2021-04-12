<?php

namespace App\Http\Controllers\ServiceRequest;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Rfq;
use App\Models\ServiceRequestWarranty;
use App\Models\SubStatus;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\In;

use App\Traits\Loggable;

class ClientDecisionController extends Controller
{
    use Loggable;

    public function __construct() {
        $this->middleware('auth:web');
    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $clientAcceptedId = SubStatus::select('id')->where('phase', 9)->first();
        $clientDeclinedId = SubStatus::select('id')->where('phase', 10)->first();
        $invoice = Invoice::find($request->invoice_id);
//        dd($invoice['uuid']);
        $warranty = $request['warranty_id'] ? Warranty::findOrFail($request->warranty_id) : '' ;
        if ($request['client_choice'] == 'accepted')
        {
//            dd($request);
            if($request['invoice_type'] == 'Supplier Invoice')
            {
                $rfq = Rfq::where('service_request_id', $invoice->serviceRequest->id)->first();
                \Illuminate\Support\Facades\DB::transaction(function () use ($invoice, $rfq) {
                    //Update the RFQ Table
                    $rfq->update([
                        'status' => 'Accepted',
                        'accepted' => 'Yes'
                    ]);

                    // Update the Supplier Invoice row to hide the Invoice from the client
                    $invoice->update([
                        'phase' => '0'
                    ]);
                    $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ' accepted supplier return invoice.');

                });
                return redirect()->route('client.service.all', app()->getLocale())->with('success', 'Supplier Return Invoice Accepted');
            }
            else
            {
                \Illuminate\Support\Facades\DB::transaction(function () use ($invoice, $request, $warranty, $clientAcceptedId, &$rfq) {
                    $InitiateWarranty = ServiceRequestWarranty::create([
                        'client_id'           => $request->client_id,
                        'warranty_id'         => $request->warranty_id,
                        'service_request_id'  => $request->request_id,
                        'amount'              => $warranty->percentage * $request->amount
                    ]);
                    if($InitiateWarranty) {
                        \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $request->request_id, 2, $clientAcceptedId->id);
                        $invoice->update([
                            'phase' => '0'
                        ]);
                    }
                    $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ' accepted estimated final invoice.');
                });
                return redirect()->route('client.service.all', app()->getLocale())->with('success', 'Estimated Final Invoice Accepted');
            }
        }

        else if($request['client_choice'] == 'declined')
        {
            if($request['invoice_type'] == 'Supplier Invoice')
            {
                $diagnosisInvoice = Invoice::where('service_request_id', $invoice['service_request_id'])->where('invoice_type', 'Diagnosis Invoice')->first();
                $rfq = Rfq::where('service_request_id', $invoice->serviceRequest->id)->first();
                \Illuminate\Support\Facades\DB::transaction(function () use ($invoice, $diagnosisInvoice, $rfq) {
                    //Update the RFQ Table
                    $rfq->update([
                        'status' => 'Rejected',
                        'accepted' => 'No'
                    ]);
                    // Update the Diagnosis Invoice row to display the Invoice to the client
                    $diagnosisInvoice->update([
                        'phase' => '2'
                    ]);

                    // Update the Supplier Invoice row to hide the Invoice from the client
                    $invoice->update([
                        'phase' => '0'
                    ]);
                    $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ' declined supplier return invoice.');
                });
                return redirect()->route('invoice', [app()->getLocale(), $diagnosisInvoice->uuid])->with('success', 'Diagnosis Invoice Accepted');
            }
            else{
                \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $request->request_id, 2, $clientDeclinedId->id);
                $invoice->update([
                    'phase' => '2'
                ]);
                $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ' accepted diagnosis invoice.');
                return redirect()->route('invoice', [app()->getLocale(), $invoice->uuid])->with('success', 'Diagnosis Invoice Accepted');
            }
        }
    }
}
