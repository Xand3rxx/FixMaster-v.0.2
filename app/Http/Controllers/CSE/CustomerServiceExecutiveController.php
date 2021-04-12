<?php

namespace App\Http\Controllers\CSE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\RatingController;
use App\Models\Account;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Support\Facades\Route;

use App\Traits\Loggable;


class CustomerServiceExecutiveController extends Controller
{
    use Loggable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cse.index');
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($language, $cse)
    {
        $user = User::where('uuid', $cse)->first();
        return view('cse.view_profile', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($language, $cse)
    {
        $user = User::where('uuid', $cse)->first();
        return view('cse.edit_profile', [
            'user' => $user,
            'banks' => \App\Models\Bank::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($language, Request $request, $cse)
    {
        $this->validateUpdateRequest();
        $accountExists = Account::where('user_id', auth()->user()->id)->first();
        $contactExists = Contact::where('user_id', auth()->user()->id)->first();

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $accountExists, $contactExists) {
            // Update CSE Accounts Records table
            $accountExists->update([
                'first_name'        => $request->input('first_name'),
                'middle_name'       => $request->input('middle_name'),
                'last_name'         => $request->input('last_name'),
                'gender'            => $request->input('gender'),
                'bank_id'           => $request->input('bank_id'),
                'account_number'    => $request->input('account_number'),
            ]);

            // Update CSE Contacts Records table
            $contactExists->update([
                'full_address'      => $request->input('full_address'),
            ]);
            $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ') Job.');
        });

        return redirect()->route('cse.view_profile', [app()->getLocale(), $cse])->with('success', 'Account Updated Successfully');
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

    public function user_rating(Request $request, RatingController $ratings)
    {
        return $ratings->handleRatings($request);
    }

     /**
     *
     *
     */
    public function update_cse_service_rating($language, Request $request, RatingController $updateRatings)
    {
        return $updateRatings->handleServiceRatings($request);
    }

    private function validateUpdateRequest()
    {
        return request()->validate([
            'first_name'         => 'required|string',
            'middle_name'        => 'string',
            'last_name'          => 'required|string',
            'gender'             => 'required',
            'phone_number'       => 'required|numeric|min:11',
            'profile_avatar'     => 'file',
            'bank_id'            => 'required',
            'account_number'     => 'numeric',
            'full_address'       => 'required',
        ]);
    }
}
