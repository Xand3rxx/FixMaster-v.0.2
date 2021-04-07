<?php

namespace App\Http\Controllers\CSE;

use App\Models\Cse;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cse.requests.index', [
            'requests' => \App\Models\ServiceRequestAssigned::where('user_id', auth()->user()->id)->with(['service_request', 'service_request.users', 'service_request.client'])->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $labguage
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid)
    {
        // find the service reqquest using the uuid and relations
        $service_request = \App\Models\ServiceRequest::where('uuid', $uuid)->with(['price', 'service', 'service.sub_service'])->firstOrFail();
        // find the technician role CACHE THIS DURING PRODUCTION
        $technicainsRole = \App\Models\Role::where('slug', 'technician-artisans')->first();
        (array) $variables = [
            'service_request' => $service_request,
            'technicains' => \App\Models\UserService::where('service_id', $service_request->service_id)->where('role_id', $technicainsRole->id)->with('user')->get(),
        ];
        if ($service_request->status_id == 2) {
            $service_request_progresses = \App\Models\ServiceRequestProgress::where('user_id', auth()->user()->id)->latest('created_at')->first();
            // Determine Ongoing Status List
            $variables = array_merge($variables, [
                'tools' => \App\Models\ToolInventory::all(),
                'latest_service_request_progress' => $service_request_progresses,
                'ongoingSubStatuses' => \App\Models\SubStatus::where('status_id', 2)
                    ->when($service_request_progresses->sub_status_id <= 10, function ($query, $sub_status) {
                        return $query->whereBetween('phase', [2, 6]);
                    }, function ($query) {
                        return $query->where('recurrence', 'yes')->whereBetween('phase', [1, 20]);
                    })->get(['id', 'uuid', 'name']),
            ]);
            if ($service_request_progresses->sub_status_id >= 17) {
                // find the Issued RFQ
                $service_request->load(['rfqs' => function ($query) {
                    $query->where('status','Awaiting')->where('accepted', 'no')->with('rfqBatches','rfqSupplier', 'rfqSupplier.supplier')->first();
                }]);
                    // dd($service_request->load(['rfqs' => function ($query) {
                    //     $query->where('status','Awaiting')->where('accepted', 'no')->with('rfqBatches','rfqSupplier', 'rfqSupplier.supplier')->first();
                    // }]), $service_request['rfqs'][0]['rfqSupplier']['supplier']['account']['last_name'] .' '.$service_request['rfqs'][0]['rfqSupplier']['supplier']['account']['first_name']);
            }
            // dd($variables);
        }


        return view('cse.requests.show', $variables);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
