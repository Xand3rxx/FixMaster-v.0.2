<?php

namespace App\Http\Controllers\QualityAssurance;

use App\Http\Controllers\Controller;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Route;
use Auth;
use Session;
use App\Models\User;
use App\Models\QA;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class QualityAssuranceProfileController extends Controller
{
    public function view_profile(Request $request){
        $user = User::where('id', Auth::id())->first();
        return view('qa.view_profile', compact('user'));
    }

    public function edit(Request $request){
         $result = User::findOrFail(Auth::id());
        return view('qa.edit_profile', compact('result'));
    }

    public function update(Request $request){
        $user = User::where('id', Auth::id())->first();
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
    }

    $user->account->update([
        'user_id'=>$user->id,
        'first_name' =>$request->first_name,
        'middle_name'=>$request->middle_name,
        'last_name'=>$request->last_name,
        'gender'=>$request->gender,
        'avatar'=>$filename,
    ]);

    $user->update([
        'email'=>$request->email,
    ]);

    $user->phone->update([
        'user_id'=>$user->id,
        'number'=>$request->phone_number,
    ]);

    $type = "Profile Update";
    $severity = "Success";
    $actionUrl = Route::currentRouteAction();
    $message = $user->first_name.' '.$user->last_name.' successfully updated '.$user->account->gender=="male"?'his':'her'.' profile';
    //$this->log($type, $severity, $actionUrl, $message);

    return redirect()->back()->with('success', 'Your profile has been updated successfully');

}
    }
}
