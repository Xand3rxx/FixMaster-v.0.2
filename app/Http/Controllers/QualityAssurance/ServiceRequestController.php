<?php

namespace App\Http\Controllers\QualityAssurance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequestAssigned;

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

        foreach($allRequests as $serviceRequest){
            $canceled = $serviceRequest->service_request->status_id;
        }

        // if($res == 3){
        //     $canceled = $res;
        // }

        return view('quality-assurance.index', compact('allRequests','canceled'));
    }

    // public function chat_data(){

    //     $result = ServiceRequestAssigned::where('user_id', Auth::id())->get();


    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function get_requests(Request $request)
    {
        // $results = ServiceRequestAssigned::where('user_id', Auth::id())
        //            ->orderBy('created_at', 'DESC')->get();
        // return view('quality-assurance.requests', compact('results'));

        $results = ServiceRequestAssigned::where('user_id', Auth::id())->with('service_request')->get();

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
    public function show($id)
    {
        //
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
