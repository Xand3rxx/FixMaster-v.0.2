<?php

namespace App\Http\Controllers\CSE;

use App\Models\Cse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Log;


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
        $service_request = \App\Models\ServiceRequest::where('uuid', $uuid)->with(['price', 'service', 'service.subServices'])->firstOrFail();
        
        $request_progress = \App\Models\ServiceRequestProgress::where('service_request_id', $service_request->id)->with('user', 'substatus')->latest('created_at')->get();

        // find the technician role CACHE THIS DURING PRODUCTION
        $technicainsRole = \App\Models\Role::where('slug', 'technician-artisans')->first();
        (array) $variables = [
            'service_request' => $service_request,
            'technicains' => \App\Models\UserService::where('service_id', $service_request->service_id)->where('role_id', $technicainsRole->id)->with('user')->get(),
            'qaulity_assurances'    =>  \App\Models\Role::where('slug', 'quality-assurance-user')->with('users')->firstOrFail(),
            'request_progress' => $request_progress,
        ];
        if ($service_request->status_id == 2) {
            $service_request_progresses = \App\Models\ServiceRequestProgress::where('user_id', auth()->user()->id)->latest('created_at')->first();
            // Determine Ongoing Status List
            $variables = array_merge($variables, [
                'tools' => \App\Models\ToolInventory::all(),
                'latest_service_request_progress' => $service_request_progresses,
                'ongoingSubStatuses' => \App\Models\SubStatus::where('status_id', 2)
                    ->when($service_request_progresses->sub_status_id <= 13, function ($query, $sub_status) {
                        return $query->whereBetween('phase', [4, 9]);
                    }, function ($query) {
                        return $query->whereBetween('phase', [20, 27]);
                    })->get(['id', 'uuid', 'name']),
            ]);
            if ($service_request_progresses->sub_status_id >= 13) {
                // find the Issued RFQ
                $service_request->load(['rfqs' => function ($query) {
                    $query->where('status', 'Awaiting')->where('accepted', 'No')->with('rfqBatches', 'rfqSupplier', 'rfqSupplier.supplier')->first();
                }]);
            }
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

    public function getServiceRequestsByTechnician(Request $request)
    {
       $technicianServices = DB::table('service_request_assigned')
       ->join('service_requests', 'service_request_assigned.service_request_id', '=', 'service_requests.id')
       ->orderBy('service_request_assigned.created_at', 'DESC')
       ->select('service_requests.unique_id')
       ->where('service_request_assigned.user_id', $request->userid)
       ->where('service_request_assigned.status', 'Active')
       ->get();


       if(!empty($technicianServices)){
        return response()->json(["data" => $technicianServices], 200);
        }
        return response()->json(["message" => "No ongoing jobs available"], 404);
   
    }

    public function getServiceRequestsByCse(Request $request)
    {
       $cseServices = DB::table('service_request_assigned')
       ->join('service_requests', 'service_request_assigned.service_request_id', '=', 'service_requests.id')
       ->orderBy('service_request_assigned.created_at', 'DESC')
       ->select('service_requests.unique_id')
       ->where('service_request_assigned.user_id', $request->userid)
       ->where('service_request_assigned.status', 'Active')
       ->get();


       if(!empty($cseServices)){
        return response()->json(["data" => $cseServices], 200);
        }
        return response()->json(["message" => "No ongoing jobs available"], 404);
   
    }


    public function getUsersByReferenceID(Request $request)
    {
       $users = DB::table('service_request_assigned')
       ->join('users', 'service_request_assigned.user_id', '=', 'users.id')
       ->join('accounts', 'accounts.user_id', '=', 'service_request_assigned.user_id')
       ->join('service_requests', 'service_requests.id', '=', 'service_request_assigned.service_request_id')
       ->orderBy('service_request_assigned.created_at', 'DESC')
       ->select('service_request_assigned.user_id', 'users.email' ,'accounts.first_name', 'accounts.last_name')
       ->where('service_requests.unique_id', $request->reqid)
       ->where('service_request_assigned.status', 'Active')
       ->get();

       if(!empty($users)){
        return response()->json(["data" => $users], 200);
        }
        return response()->json(["message" => "No Users"], 404);

    }
}