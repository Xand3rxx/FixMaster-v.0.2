<?php

namespace App\Http\Controllers\CSE;

use App\Http\Controllers\Controller;
use App\Models\Cse;
use Illuminate\Http\Request;

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
        // 2. Find the status for Assigning technician record
        $status = \App\Models\SubStatus::where('name', 'Assigned a Technician')->firstOrFail();
        // Check the service request progresses table if authenticated user->id equals user_id 
        $service_request_progresses = \App\Models\ServiceRequestProgress::where(function ($query) {
            $query->where('user_id', auth()->user()->id)->Where('status_id', 2);
        })->get();

        // Find servie of the current Service Request
        $service = \App\Models\Service::where('id', $service_request->service_id)->with('sub_service')->first();
        // dd($service);
        // find the technician role
        // $technicainsRole = \App\Models\Role::where('slug', 'technician-artisans')->first();
        // List of technicians in this service request
        // $technicains = \App\Models\UserService::where('service_id', $service_request->service_id)->where('role_id', $technicainsRole->id)->with('user')->get();

        // dd($service_request, $technicains);
        return view('cse.requests.show', [
            'tools' => \App\Models\ToolInventory::all(),
            'ongoingSubStatuses' => \App\Models\SubStatus::where('status_id', 2)->whereBetween('phase', [4, 8])->get(['id', 'uuid', 'name']),
            'warranties' => \App\Models\Warranty::all(),
            'service_request' => $service_request,
            'service'   => $service
            // 'technicains' => $technicains,
            // 'statuses' => \App\Models\Status::where('name','Ongoing')->select('sub_status')->first()
        ]);
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
