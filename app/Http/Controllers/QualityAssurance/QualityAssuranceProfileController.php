<?php

namespace App\Http\Controllers\QualityAssurance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    $user->account->update([
        'user_id'=>$user->id,
        'first_name' =>$request->first_name,
        'middle_name'=>$request->middle_name,
        'last_name'=>$request->last_name,
        'gender'=>$request->gender,
        'avatar'=>$request->profile_avater,
    ]);

    $user->update([
        'email'=>$request->email,
    ]);

    $user->phone->update([
        'user_id'=>$user->id,
        'number'=>$request->phone_number,
    ]);

    return redirect()->back()->with('success', 'Your profile has been updated successfully');

}
    }

    public function update_password(Request $request){

        $user = User::where('id', Auth::id())->first();
        $old_password = $user->password;
        $input = $request->all();
        $new_password = $request->input('new_password');
        $repeat_password = $request->input('new_confirm_password');


         if($new_password == $repeat_password){

        if(Hash::check($request->current_password, $user->password)){
           $changed_password = Hash::make($new_password);
           $user->update(['password' => $changed_password]);

           return redirect()->back()->with('success', 'Password changed successfully!');
            }

          }
         return redirect()->back()->with('error', 'Sorry your credentials do not match!');

       }

}
