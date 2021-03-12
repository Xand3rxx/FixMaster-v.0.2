<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Traits\Loggable;
use Illuminate\Support\Facades\Route;
use Auth;
use Session;
use App\Models\PaymentDisbursed;
use App\Models\User;
use App\Models\Technician;
use App\Models\ServiceRequest;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class TechnicianProfileController extends Controller
{
    use Loggable;
    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    public function __construct() {
        $this->middleware('auth:web');
    }

    /**
     * Return Technician Dashboard
     */
    public function index(){

        return view('technician.index')->with('i');
    }

    /**
     * Return Location Request Page 
     */
    public function locationRequest(){

        return view('technician.location_request')->with('i');
    }

    /**
     * Return Payments Page 
     */
    public function payments(){

        return view('technician.payments')->with('i');
    }

    /**
     * Return Service Requests Page 
     */
    public function serviceRequests($language, ServiceRequest $serviceRequest){

        $user_id = auth()->user()->id; // gets the current user id
       
        $serviceRequest = ServiceRequest::where('technician_id', $user_id)->orderBy('id', 'DESC')->paginate(15);
        
        return view('technician.requests', compact('serviceRequest'));

        //return view('technician.requests')->with('i');
    }

    /**
     * Return Service Requests Details Page 
     */
    public function serviceRequestDetails($language, ServiceRequest $serviceRequest)
    {

        $user_id = auth()->user()->id; // gets the current user id
       
        $serviceRequest = ServiceRequest::where('technician_id', $user_id)->orderBy('id', 'DESC')->paginate(15);
        
        return view('technician.request_details', compact('serviceRequest'));
        
       }

    /**
     * Return View Profile Page 
     */
    public function viewProfile(Request $request){
        
            $user = User::where('id', Auth::id())->first();
            return view('technician.view_profile', compact('user'));
            //return view('technician.view_profile');
    }

    /**
     * Return Account Settings Page 
     */
    public function editProfile(Request $request){

        $result = User::findOrFail(Auth::id());
        return view('technician.edit_profile', compact('result'));

        //return view('technician.edit_profile');
    }

    public function updateProfile(Request $request){
        $user = User::where('id', Auth::id())->first();
        if($user->account->gender == "male"){
            $res = "his";
        }else{
            $res ="her";
        }
    
        $type = "Profile";
        $severity = "Informational";
        $actionUrl = Route::currentRouteAction();
        $message = $user->email.' profile successfully updated ';
            $rules = [
                'first_name' => 'required|max:255',
                'middle_name' => 'required|max:255',
                'last_name' => 'required|max:255',
                'gender' => 'required|max:255',
                'email' => 'required|email',
                'phone_number' => 'required',
                'profile_avater' => 'mimes:jpeg,jpg,png,gif'
                // 'full_address' => 'required',
                // 'work_address' => '',
    
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
    if($validator->fails()){
        return redirect()->back()->with('errors', $validator->errors());
    }else{
    
        if($request->hasFile('profile_avater')){
            $filename = $request->profile_avater->getClientOriginalName();
            $request->profile_avater->move('assets/qa_images', $filename);
        }else{
            $filename = $user->account->avatar;
        }
    
        $user->account->update([
            'user_id'=>$user->id,
            'first_name' =>$request->first_name,
            'middle_name'=>$request->middle_name,
            'last_name'=>$request->last_name,
            'gender'=>$request->gender,
            'avatar'=>$filename
        ]);
    
        $user->update([
            'email'=>$request->email,
        ]);
    
        $user->phone->update([
            'user_id'=>$user->id,
            'number'=>$request->phone_number,
        ]);
    
        $this->log($type, $severity, $actionUrl, $message);
    
        return redirect()->back()->with('success', 'Your profile has been updated successfully');
    
    }
        }
    


    public function updatePassword(Request $request){

        $user = User::where('id', Auth::id())->first();
        $current_password = $request->input('current_password');
        $new_password = $request->input('new_password');
        $new_confirm_password = $request->input('new_confirm_password');

        $type = "Profile";
        $severity = "Informational";
        $actionUrl = Route::currentRouteAction();
        $message = $user->email.' profile successfully updated';

         if($new_password === $new_confirm_password){

        if(Hash::check($request->current_password, $user->password)){
           $changed_password = Hash::make($new_password);
           $user->update(['password' => $changed_password]);
           
           $this->log($type, 'informational', $actionUrl, $user->email.' Password changed successfully');
           return redirect()->back()->with('success', 'Password changed successfully!');
            }
            $this->log($type, 'error', $actionUrl,  $user->email. 'Password updating failed, current password do not match our record');
            return redirect()->back()->with('error', 'Your current password do not match our record');

          }
          $this->log($type, 'error', $actionUrl,  $user->email.' Password updating failed, new password and confirm password do not match');
         return redirect()->back()->with('error', 'Your new password and confirm password do not match');

       }

       public function get_technician_disbursed_payments(Request $request){

        // $user = Auth::user();
        // $payments = $user->payments();
        $payments = PaymentDisbursed::where('recipient_id',Auth::id())->get();
        return view('technician.payments', compact('payments'));
    }
    
}
