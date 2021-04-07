<?php

namespace App\Http\Controllers\ServiceRequest;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\SubStatus;
use Illuminate\Http\Request;

class ClientDecisionController extends Controller
{
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
        if ($request['client_choice'] == 'accepted')
        {
            \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $request->request_id, 2, $clientAcceptedId->id);
            $invoice->update([
                'phase' => '0'
            ]);

            if(auth()->user()->type->role->url == 'client')
            {
                return redirect()->route('client.service.all', app()->getLocale())->with('success', 'Diagnosis Invoice Accepted');
            }
            else
            {
                return redirect()->route('cse.requests.show', [app()->getLocale(), $request->request_uuid])->with('success', 'Diagnosis Invoice Accepted');
            }

        }
        else if($request['client_choice'] == 'declined')
        {
            \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $request->request_id, 2, $clientDeclinedId->id);
            $invoice->update([
                'phase' => '2'
            ]);

            if(auth()->user()->type->role->url == 'client')
            {
                return redirect()->route('client.service.all', app()->getLocale())->with('success', 'Diagnosis Invoice Accepted');
            }
            else
            {
                return redirect()->route('cse.requests.show', [app()->getLocale(), $request->request_uuid])->with('success', 'Diagnosis Invoice Accepted');
            }
        }
    }
}