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
     *
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
    public function show($language, string $uuid)
    {
        // find the service request using the uuid and relations
        $service_request = ServiceRequest::where('uuid', $uuid)->with(['price', 'service', 'service.subServices', 'client'])->firstOrFail();

        $technicians = \App\Models\Technician::with('services', 'user', 'user.contact')->get();

        $materials_accepted = \App\Models\Rfq::where('service_request_id', $service_request->id)->with('rfqBatches', 'rfqSupplier', 'rfqSupplierInvoice');
        $service_request_progresses = \App\Models\ServiceRequestProgress::where('user_id', auth()->user()->id)->latest('created_at')->first();
        
        (array) $variables = [
            'contents'              => $this->path(base_path('contents/cse/service_request_action.json')),
            'service_request'       => $service_request,
            'tools'                 => \App\Models\ToolInventory::all(),
            'qaulity_assurances'    => \App\Models\Role::where('slug', 'quality-assurance-user')->with('users', 'users.account')->firstOrFail(),
            'technicians'           => $technicians,
            'categories'            => \App\Models\Category::where('id', '!=', 1)->get(),
            'services'              => \App\Models\Service::all(),
            'ongoingSubStatuses' => \App\Models\SubStatus::where('status_id', 2)
                    ->when($service_request_progresses->sub_status_id <= 13, function ($query, $sub_status) {
                        return $query->whereBetween('phase', [4, 9]);
                    }, function ($query) {
                        return $query->whereBetween('phase', [20, 27]);
                    })->get(['id', 'uuid', 'name']),
            'stage'                 => collect($service_request['sub_services'])->isEmpty() ? ServiceRequest::CSE_ACTIVITY_STEP['schedule_categorization'] : ServiceRequest::CSE_ACTIVITY_STEP['add_technician'],
        ];
        // dd($service_request);
        return view('cse.requests.show', $variables);
    }

    /**
     * Send Notification
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $request->all();
        $valid = $request->validate(['service_request' => 'required|uuid']);
        $serviceRequest = ServiceRequest::where('uuid', $valid['service_requests'])->with('client', 'client.user')->firstOrFail();
        $user = $serviceRequest['client']['user'];
        // Define a Feature
        $template_feature = 'CSE_ACCOUNT_CREATION_NOTIFICATION';
        // Build possible Parameters
        $mail_data = collect([
            // 'lastname' => $applicant->form_data['last_name'],
            // 'firstname' => $applicant->form_data['first_name'],
            // 'email' => $applicant->form_data['email'],
        ]);
        // Instantiate Contoller
        $messanger = new \App\Http\Controllers\Messaging\MessageController();
        return $messanger->sendNewMessage('email', \Illuminate\Support\Str::title(\Illuminate\Support\Str::of($template_feature)->replace('_', ' ',)), 'dev@fix-master.com', $mail_data['email'], $mail_data, $template_feature);
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