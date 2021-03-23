<?php

namespace App\Http\Controllers\QualityAssurance;

use App\Http\Controllers\Controller;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use App\Models\QA;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class QualityAssuranceProfileController extends Controller
{
    use Loggable;

    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function view_profile(Request $request){
        $user = User::where('id', Auth::id())->first();
        return view('quality-assurance.view_profile', compact('user'));
    }

    public function edit(Request $request){
         $result = User::findOrFail(Auth::id());
        return view('quality-assurance.edit_profile', compact('result'));
    }

    public function update(Request $request){
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
            'phone_number' => 'required',
            'profile_avater' => 'mimes:jpeg,jpg,png,gif',
            'full_address' => 'required'
            // 'work_address' => '',

          ];

          $messages = [
             'first_name.required' => 'First Name field can not be empty',
             'middle_name.required' => 'Middle Name field can not be empty',
             'last_name.required' => 'Last Name field can not be empty',
             'gender.required' => 'Please select gender',
             'phone_number.required' => 'Please select phone number',
             'profile_avater.mimes'    => 'Unsupported Image Format'
          ];

          $validator = Validator::make($request->all(), $rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }else{

        if($request->hasFile('profile_avater')){
            $filename = $request->profile_avater->getClientOriginalName();
            $request->profile_avater->move('assets/user-avatars', $filename);
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

    $user->phone->update([
        'user_id'=>$user->id,
        'number'=>$request->phone_number,
    ]);

    $user->address->update([
        'user_id'=>$user->id,
        'name'=>$request->full_address,
    ]);

    $this->log($type, $severity, $actionUrl, $message);

    return redirect()->back()->with('success', 'Your profile has been updated successfully');

}
    }


    public function update_password(Request $request){

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
}
