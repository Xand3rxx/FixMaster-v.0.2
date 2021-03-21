<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Loggable;
use Illuminate\Support\Facades\Route;
use Auth;
use App\Models\PaymentDisbursed;
use App\Models\User;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestAssigned;
use Illuminate\Support\Facades\DB;
use App\Traits\PasswordUpdator;
use Illuminate\Support\Facades\Validator;

class TechnicianProfileController extends Controller
{
    use Loggable, PasswordUpdator;
    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Return Technician Dashboard
     */
    public function index()
    {

        return view('technician.index')->with('i');
    }

    /**
     * Return Location Request Page 
     */
    public function locationRequest()
    {

        return view('technician.location_request')->with('i');
    }

    /**
     * Return Payments Page 
     */
    public function payments()
    {

        return view('technician.payments')->with('i');
    }

    /**
     * Return Service Requests Page 
     */
    public function serviceRequests($language, ServiceRequestAssigned $serviceRequest)
    {

        $user_id = auth()->user()->id; // gets the current user id

        //$serviceRequests = ServiceRequestAssigned::where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(15);
        //$serviceRequests = ServiceRequestAssigned::where('user_id', Auth::id())->get();
        
        //$serviceRequests = DB::table('ServiceRequestAssigned')->join('ServiceRequest', 'ServiceRequestAssigned.service_request_id', '=', 'ServiceRequest.service_id' ))

        /*DB::table('USER')
        ->join('FOLLOWERS', 'USER.id', '=', 'FOLLOWERS.user_id')
        ->join('SHARES', 'FOLLOWERS.follower_id', '=', 'SHARES.user_id')
        ->where('USER.id', 3)
        ->get();*/

        $serviceRequests = DB::table('service_request_assigned')->join('service_requests', 'service_request_assigned.service_request_id', '=', 'service_requests.service_id' )
  ->join('accounts', 'service_requests.client_id', '=', 'accounts.user_id')
  ->where('service_request_assigned.user_id', $user_id)
  ->get();
  

        return view('technician.requests', compact('serviceRequests'));

        //return view('technician.requests')->with('i');
    }

    /**
     * Return Service Requests Details Page 
     */
    public function serviceRequestDetails($language, $service_request_id)
    {

        $user_id = auth()->user()->id; // gets the current user id

       // $serviceRequests = ServiceRequestAssigned::where('user_id', $user_id)->orderBy('created_at', 'DESC')->paginate(15);

        $serviceRequests = DB::table('service_request_assigned')->join('service_requests', 'service_request_assigned.service_request_id', '=', 'service_requests.service_id' )
  ->join('accounts', 'service_requests.client_id', '=', 'accounts.user_id')
  ->join('addresses', 'service_requests.client_id', '=', 'addresses.user_id')
  //->join('services', 'service_request_assigned.service_request_id', '=', 'services.user_id')
  ->where('service_requests.service_id', $service_request_id)->first();
      
  //dd($service_request_id);
        return view('technician.request_details', compact('serviceRequests'));
    }

    /**
     * Return View Profile Page 
     */
    public function viewProfile(Request $request)
    {

        $user = User::where('id', Auth::id())->first();
        return view('technician.view_profile', compact('user'));
        //return view('technician.view_profile');
    }

    /**
     * Return Account Settings Page 
     */
    public function editProfile(Request $request)
    {

        $result = User::findOrFail(Auth::id());
        return view('technician.edit_profile', compact('result'));

        //return view('technician.edit_profile');
    }

    public function updateProfile(Request $request)
    {
        $user = User::where('id', Auth::id())->first();
        
        if ($user->account->gender == "male") {
            $res = "his";
        } else {
            $res = "her";
        }

        $type = "Profile";
        $severity = "Informational";
        $actionUrl = Route::currentRouteAction();
        $message = $user->email . ' profile successfully updated ';
        $rules = [
            'first_name' => 'required|max:255',
            'middle_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'gender' => 'required|max:255',
            'email' => 'required|email',
            'phone_number' => 'required',
            'profile_avater' => 'mimes:jpeg,jpg,png,gif',
            'full_address' => 'required',
            'work_address' => '',

        ];

        $messages = [
            'first_name.required' => 'First Name field can not be empty',
            'middle_name.required' => 'Middle Name field can not be empty',
            'last_name.required' => 'Last Name field can not be empty',
            //  'profile_avater.required' => '',
            'gender.required' => 'Please select gender',
            'email.required' => 'Email field can not be empty',
            'phone_number.required' => 'Please select phone number',
            'profile_avater.mimes'    => 'Unsupported Image Format',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {

            if ($request->hasFile('profile_avater')) {
                $filename = $request->profile_avater->getClientOriginalName();
                $request->profile_avater->move('assets/qa_images', $filename);
            } else {
                $filename = $user->account->avatar;
            }

            $user->account->update([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'avatar' => $filename
            ]);


            $user->update([
                'email' => $request->email,
            ]);

            $user->phone->update([
                'user_id' => $user->id,
                'number' => $request->phone_number,
            ]);

           /*$user->address->update([
                'user_id' => $user->id,
                'address' => $request->full_address,
               
            ]);*/

            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->back()->with('success', 'Your profile has been updated successfully');
        }
    }




    /**
     * Update password of the current request user
     * 
     * PLEASE INCLUDE IN FORM REQUEST THE NAME:
     * 
     * 1: current_password
     * 
     * 2: new_password
     * 
     * 3: new_confirm_password 
     * 
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     * 
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePassword(Request $request)
    {
        return $this->passwordUpdator($request);
    }

    public function get_technician_disbursed_payments(Request $request)
    {


        $payments = PaymentDisbursed::where('recipient_id', Auth::id())->get();

        return view('technician.payments', compact('payments'));
    }
}
