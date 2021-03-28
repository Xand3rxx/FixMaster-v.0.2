<?php

namespace App\Http\Controllers\Admin\User;

use App\Traits\Utility;
use App\Traits\RegisterCSE;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerServiceExecutiveController extends Controller
{
    use Utility, RegisterCSE;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.cse.index')->with([
            'users' => \App\Models\Cse::with('user', 'user.account', 'user.contact', 'user.roles')->get(),
            // 'requests' => \App\Models\ServiceRequestAssigned::where('user_id', auth()->user()->id)->withCount('service_request')
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
            'franchisees' => \App\Models\Franchisee::select('id', 'cac_number')->latest()->get(),
            // 'town' => \App\Models\Town::select('id', 'name')->latest()->get(),
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
        // Register a CSE
        $registered = $this->register($valid);

        return ($registered == true)
            ? redirect()->route('admin.users.cse.index', app()->getLocale())->with('success', "A Customer Service Executive Account Created Successfully!!")
            : back()->with('error', "An error occurred while creating Account");
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $language
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid)
    {
        $user = \App\Models\User::where('uuid', $uuid)->with('account', 'cse', 'permissions', 'contact')->firstOrFail();
        return view('admin.users.cse.show', [
            'user' => $user,
            'last_seen' => $user->load(['logs' => function ($query) {
                $query->where('type', 'logout')->orderBy('created_at', 'asc');
            }]),
            'logs' => $user->loadCount(['logs' => function ($query) {
                $query->where('type', 'login');
            }])
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
            'franchisee_id'             =>   'required|numeric|exists:franchisees,id',

            'gender'                    =>   'required|in:Male,Female,Others',
            // 'status'                    =>   'required|in:active,inactive',

            'password'                  =>   'required|min:8',
            'confirm_password'          =>   'required|same:password',

            'bank_id'                   =>   'required|numeric',
            'account_number'            =>   'required|numeric',

            'state_id'                  =>   'required|numeric',
            'lga_id'                    =>   'required|numeric',
            'town'                      =>   'required|string',
            'full_address'              =>   'required|string',
            'address_latitude'          =>   'required|string',
            'address_longitude'         =>   'required|string',
            'phone_number'              =>   'required|numeric|unique:contacts,phone_number',

            'avatar'                    => 'sometimes|image'
        ]);
    }
}
