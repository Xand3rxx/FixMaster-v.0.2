<?php

namespace App\Http\Controllers\Frontend\ApplicantsForm;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CSEFormController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Validate Request
        dd($request->all());
        (array) $valid = $this->validate($request, [
            'first_name'                =>   'required|string|max:180',
            'middle_name'               =>   'sometimes|max:180',
            'last_name'                 =>   'required|string|max:180',
            'email'                     =>   'required|email|unique:users,email',
            'phone_number'              =>   'required|numeric',
            'role_id'                   =>   'required|numeric',
        ]);
    }
}
