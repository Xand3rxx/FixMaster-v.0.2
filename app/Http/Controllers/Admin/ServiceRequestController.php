<?php

namespace App\Http\Controllers\Admin;

use Auth;
use Route;
use Session;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Utility;
use App\Traits\Loggable;
use App\Models\ServiceRequest;

class ServiceRequestController extends Controller
{
    use Utility, Loggable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // return  ServiceRequest::with('users', 'client', 'price')->where('status_id', 1)->get();

        return view('admin.requests.pending.index', [
            'requests'  =>  ServiceRequest::with('users', 'client', 'price')->where('status_id', 1)->latest('created_at')->get()
        ]);
    }


    /**
     * Display the selected pending service request detail.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function ongoingRequestDetails($language, $uuid)
    {
        return view('admin.requests.pending.show', [
            'cses'    =>  \App\Models\Role::where('slug', 'cse-user')->with('users')->firstOrFail(),
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
     * Display the selected pending service request detail.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid)
    {

        // return ServiceRequest::where('uuid', $uuid)->with(['price', 'service', 'service.subServices'])->firstOrFail();

        return view('admin.requests.pending.show', [
            'serviceRequest'    =>  ServiceRequest::where('uuid', $uuid)->with(['price', 'service', 'service.subServices'])->firstOrFail(),
            'cses'    =>  \App\Models\Role::where('slug', 'cse-user')->with('users')->firstOrFail(),
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


    public function markCompletedRequest(Request $request, $language, $id){
   
        $requestExists =  \App\Models\ServiceRequest::where('uuid', $id)->firstOrFail();

         $updateMarkasCompleted = $this->markCompletedRequestTrait(Auth::id(), $id);

        if($updateMarkasCompleted ){

            $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ') marked '.$requestExists->unique_id.' service request as completed.');

            return redirect()->route('admin.requests.index', app()->getLocale())->with('success', $requestExists->unique_id.' was marked as completed successfully.');
        }else{
           
         //activity log
            return back()->with('error', 'An error occurred while trying to mark '.$requestExists->unique_id.' service request as completed.');
        }
    }


}
