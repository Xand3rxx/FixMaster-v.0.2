<?php

namespace App\Http\Controllers\Frontend\ApplicantsForm;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
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
        (array) $valid = $this->validate($request, [
            'first_name_cse'         =>   'bail|required|string|max:180',
            'last_name_cse'          =>   'bail|required|string|max:180',
            'phone_cse'              =>   'bail|required|min:8',
            'email_cse'              =>   'bail|required|email|unique:users,email',
            'gender_cse'             => 'required|in:male,female,others',
            'date_of_birth_cse'      => 'required|date|max:' . now()->subYears(18)->toDateString(),
            'address_cse'            =>   'required|string',
            'address_latitude'       =>   'sometimes|string',
            'address_longitude'      =>   'sometimes|string',
            'cv_cse'                 => 'required||max:3000|mimetypes:application/msword,application/pdf,application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'referral_code_cse'      => 'sometimes|string|nullable',

        ]);

        if ($request->hasFile('cv_cse')) {
            $valid = array_merge($valid, ['cv_cse' => $valid['cv_cse']->store('assets/applicant-uploads', 'public')]);
        }

        return collect(Applicant::create(['user_type' => Applicant::USER_TYPES[0],  'form_data' => $valid]))->isNotEmpty()
            ? back()->with('success', 'Application submitted successfully!!')
            : back()->with('error', 'Error Submitting Application, Retry!!');
    }
}
