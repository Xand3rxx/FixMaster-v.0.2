<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Utility;

class CustomerServiceExecutiveController extends Controller
{
    use Utility;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.cse.index')->with([
            'users' => \App\Models\Cse::with('user')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.cse.create')->with([
            'states' => \App\Models\State::select('id', 'name')->orderBy('name', 'ASC')->get(),
            'banks' => \App\Models\Bank::select('id', 'name')->orderBy('name', 'ASC')->get(),
            // services
            'services' => [
                'Electronics'        => [
                    '1' => 'Computer & Laptops'
                ],
                'Household Appliances' => [
                    '1' => 'Dish & Washing Machine'
                ]
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate Request
        $valid = $this->validateCreateCustomerServiceExecutive($request);
  
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
    protected function validateCreateCustomerServiceExecutive(Request $request)
    {
        return $request->validate([
            'first_name'                =>   'required|string|max:180',
            'middle_name'               =>   'sometimes|max:180',
            'last_name'                 =>   'required|string|max:180',
            'email'                     =>   'required|email|unique:users,email',
            'phone_number'              =>   'required|numeric|unique:phones,number',
            'other_phone_number'        =>   'sometimes|numeric|unique:phones,number',
            'gender'                    =>   'required|in:Male,Female,Others',
            'password'                  =>   'required|min:8',
            'confirm_password'          =>   'required|same:password',
            'technician_category'       =>   'required|array',
            'technician_category.*'     =>   'required|string',

            'bank_id'                   =>   'required|numeric',
            'state_id'                  =>   'required|numeric',
            'lga_id'                    =>   'required|numeric',
            'town'                      =>   'required|string',
            'full_address'              =>   'required|string',
            'account_number'            =>   'required|numeric',

        ]);
    }
}
