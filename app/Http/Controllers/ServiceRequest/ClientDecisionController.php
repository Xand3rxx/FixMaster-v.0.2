<?php

namespace App\Http\Controllers\ServiceRequest;

use App\Http\Controllers\Controller;
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
//        dd($request, $clientAcceptedId, $clientDeclinedId);
        if ($request['client_choice'] == 'accepted')
        {
            \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $request->request_id, 2, $clientAcceptedId->id);
            return redirect()->route('cse.requests.show', [app()->getLocale(), $request->request_uuid]);
        }
        else if($request['client_choice'] == 'declined')
        {
            \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $request->request_id, 2, $clientDeclinedId->id);
            return redirect()->route('cse.requests.show', [app()->getLocale(), $request->request_uuid]);
        }
    }
}
