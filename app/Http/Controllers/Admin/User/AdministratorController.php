<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\RegisterAdministrator;

class AdministratorController extends Controller
{
    use RegisterAdministrator;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(\App\Models\Administrator::with('account','roles')->get());
        // Users with Role of Admin or Super Admin
        // Find their Accounts
        return view('admin.users.administrator.index')->with([
            'users' => \App\Models\Administrator::with('user','account','phones','roles')->get(),
        ]);
        // return view('admin.users.admin.list', $data)->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.administrator.create')->with([
            'roles' => \App\Models\Role::where('url', 'admin')->get(),
            'permissions' => [
                'administrators'        => 'Administrators',
                'clients'               => 'Clients',
                'location_request'      => 'Location Request',
                'cses'                  => "CSE's",
                'payments'              => 'Payments',
                'ratings'               => 'Rating',
                'requests'              => 'Requests',
                'rfqs'                  => "RFQ's",
                'service_categories'    => "Service & Category",
                'technicians'           => "Technicians",
                'tools'                 => "Tools",
                'utilities'             => "Utilities",
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
        $valid = $this->validateCreateAdministrator($request);
        // Register an Administrator
        $registered = $this->register($valid);

        return ($registered == true)
            ? redirect()->route('admin.users.administrator.index', app()->getLocale())->with('success', "An Administrator Created Successfully!!")
            : back()->with('error', "An error occurred while creating User");
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
    protected function validateCreateAdministrator(Request $request)
    {
        return $request->validate([
            'first_name'                =>   'required|string|max:180',
            'middle_name'               =>   'sometimes|max:180',
            'last_name'                 =>   'required|string|max:180',
            'email'                     =>   'required|email|unique:users,email',
            'phone_number'              =>   'required|numeric',
            'role_id'                   =>   'required|numeric',
            'password'                  =>   'required|min:8',
            'confirm_password'          =>   'required|same:password',
            'permission'                => 'required|array',
            'permission.*'                => 'sometimes|required|string|in:on,off'
        ]);
    }
}
