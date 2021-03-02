<?php

namespace App\Http\Controllers\Frontend\Registration;

use App\Http\Controllers\Controller;
use App\Traits\RegisterClient;
use Illuminate\Http\Request;

class ClientRegistrationController extends Controller
{
    use RegisterClient;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.registration.client.index', [
            'states' => \App\Models\State::all(),
            'activeEstates' => \App\Models\Estate::all(),
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
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
        // dd($request->all());
        // Validate Client Registration
        $valid = $this->validateCreateClient($request);
        // Register a Client User
        $registered = $this->register($valid);
        // If registered, redirect to client url
        return ($registered == true)
            ? redirect()->route('client.index', app()->getLocale())->with('success', "User Account Created Successfully!!")
            : back()->with('error', "An error occurred while creating User Account!!");
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

    /**
     * Validate the create administrator user request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateCreateClient(Request $request)
    {
        return $request->validate([
            'state_id'                  =>   'required',
            'lga_id'                    =>   'required',
            'first_name'                =>   'required',
            'middle_name'               =>   'sometimes|nullable',
            'last_name'                 =>   'required',
            'email'                     =>   'required|email|unique:users,email',
            'phone_number'              =>   'required|Numeric|unique:phones,number',
            'gender'                    =>   'required|in:Male,Female',
            'town'                      =>   'required|string|max:190',
            'password'                  =>   'required|min:8',
            'confirm_password'          =>   'required|same:password',
            'full_address'              =>   'required',
            'terms_and_conditions'      =>   'required|accepted',
            'estate_id'                 =>   'nullable|numeric'
        ]);
    }
}
