<?php

namespace App\Http\Controllers\QualityAssurance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequestAssigned;
use App\Models\ServiceRequest;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $allRequests = ServiceRequestAssigned::where('user_id', Auth::id())->get();

        return view('quality-assurance.index', compact('allRequests'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function get_requests(Request $request)
    {
        $results = ServiceRequestAssigned::where('user_id', Auth::id())->with('users', 'service_request')
                 ->orderBy('created_at', 'DESC')->get();
                //  dd($results);
        return view('quality-assurance.requests', compact('results'));
    }

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid)
    {

        $result = ServiceRequest::where('uuid', $uuid)
                  ->orderBy('created_at', 'DESC')->first();

        return view('quality-assurance.request_details', compact('result'));
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
