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
        $service_request = \App\Models\ServiceRequest::where('uuid', $uuid)->with(['price'])->firstOrFail();
        $technicainsRole = \App\Models\Role::where('slug', 'technician-artisans')->first();

        $technicains = \App\Models\UserService::where('service_id', $service_request->service_id)->where('role_id', $technicainsRole)->get();

        dd($service_request, $technicainsRole, $technicains);
        return view('cse.requests.show', [
            'tools' => \App\Models\ToolInventory::all(),
            'ongoingSubStatuses' => \App\Models\SubStatus::where('status_id', 2)->get(['id', 'name']),
            'warranties' => \App\Models\Warranty::all(),
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
