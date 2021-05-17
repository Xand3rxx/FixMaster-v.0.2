<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Traits\Utility;
use App\Models\Warranty;
use App\Models\ServiceRequestWarranty;
use App\Models\ServiceRequestWarrantyIssued;
use Illuminate\Support\Facades\URL;
use App\Traits\Loggable;
use App\Models\PaymentDisbursed;

use Auth;
use Route;
use DB;

class WarrantyController extends Controller
{
    use Loggable, Utility;
    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    public function __construct() {
        $this->middleware('auth:web');
    
    }

    public function index()
    {
        //Return all warranty including deleted and inactive ones
        return view('admin.warranty.index', [
            'warranties' =>  Warranty::AllWarranties()->get()
        ]);
    }

    public function storeWarranty($language, Request $request)
    {
        //Validate user input fields
        $this->validateRequest();

        //Set 'createWarranty` to false
        (bool) $createWarranty = false;

        DB::transaction(function () use ($request, &$createWarranty) {

            $createWarranty = Warranty::create([
                'user_id'        =>   Auth::id(),
                'name'           =>   ucwords($request->name),
                'percentage'     =>   $request->percentage,
                'warranty_type'  =>   $request->warranty_type,
                'duration'       =>   $request->duration, 
                'description'    =>   $request->description,
            ]);

            $createWarranty = true;

        });

        if($createWarranty){
            
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' created '.ucwords($request->input('name')).' warranty';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.warranty_list', app()->getLocale())->with('success', ucwords($request->input('name')).' warranty was successfully created.');

        }else{
            
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to create warranty.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to create '.ucwords($request->input('name')).' warranty.');
        }

        return back()->withInput();
               
    }

    /**
     * Validate user input fields
     */
    private function validateRequest(){
        return request()->validate([
            'name'          =>   'required|unique:warranties,name',
            'percentage'    =>   'required|numeric',
            'duration'      =>   'required|numeric',
            'warranty_type' =>   'required', 
            'description'   =>   'required', 
        ]);
    }

    public function show($language, $details)
    {
        // return Warranty::where('uuid', $details)->with('user')->firstOrFail();
        //Return the warranty object based on the uuid
        return view('admin.warranty.warranty_details', [
            'warranty'  =>  Warranty::where('uuid', $details)->with('user')->firstOrFail()
        ]);
    }

    public function edit($language, $details)
    {
        
        //Return the warranty object based on the uuid
        return view('admin.warranty.edit_warranty', [
            'warranty'  =>  Warranty::where('uuid', $details)->firstOrFail()
        ]);
    }

    public function update($language, $details, Request $request)
    {
        //Validate user input fields
        $request->validate([
            'name'          =>   'required',
            'percentage'    =>   'required|numeric',
            'warranty_type' =>   'required',
            'duration'      =>   'required|numeric',
            'description'   =>   'required', 
        ]);

        //Set 'createWarranty` to false
        (bool) $updateWarranty = false;

        //Update Warranty
        DB::transaction(function () use ($request, &$updateWarranty, $details) {

            $updateWarranty= Warranty::where('uuid', $details)->update([
                'name'          =>   ucwords($request->name),
                'percentage'    =>   $request->percentage,
                'warranty_type' =>   $request->warranty_type,
                'description'   =>   $request->description,
            ]);

            $updateWarranty = true;
        });
        
        if($updateWarranty){

            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' updated '.ucwords($request->input('name')).' warranty';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.warranty_list', app()->getLocale())->with('success', ucwords($request->input('name')).' warranty was successfully updated.');

        }else{
            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to update warranty.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to update '.ucwords($request->input('name')).' warranty.');
        }

        return back()->withInput();
    }

    //This method delete already created warranty
    public function deleteWarranty($language, $details)
    {
        $warrantyExist = Warranty::where('uuid', $details)->firstOrFail();

        $softDeleteWarranty = $warrantyExist->delete();

        if ($softDeleteWarranty){
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$warrantyExist->name;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.warranty_list', app()->getLocale())->with('success', $warrantyExist->name.' warranty has been deleted successfully.');
        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to delete '.$warrantyExist->name;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred while trying to delete '.$warrantyExist->name);
        }
    }

    public function issuedWarranties()
    {
        // return ServiceRequestWarranty::with('user.account', 'service_request', 'warranty')->orderBy('has_been_attended_to', 'ASC')->latest()->get();

        //Return all issued warranties bt clients
        return view('admin.warranty.issued_warranties', [
            'issuedWarranties' => ServiceRequestWarranty::with('user.account', 'service_request', 'warranty')->orderBy('has_been_attended_to', 'ASC')->latest()->get()
        ]);
    }

    public function issuedWarrantyDetail($language, $uuid)
    {
        return view('admin.warranty._');
    }

    public function resolvedWarranty(Request $request, $language, $uuid)
    {
     
        $serviceRequest = ServiceRequestWarranty::where('uuid', $uuid)->with('user.account', 'service_request', 'warranty')->first();
        $warrantyExist = Warranty::where('id',  $serviceRequest->warranty_id)->first();
   
           //Set 'createWarranty` to false
           (bool) $updateWarranty = false;
           (bool) $createWarranty  = false;

           //Update ServiceRequestWarranty
           DB::transaction(function () use ($request, &$updateWarranty, $uuid) {
               $updateWarranty= ServiceRequestWarranty::where('uuid', $uuid)->update([
                   'has_been_attended_to'          =>  'Yes',
               ]);
   
               $updateWarranty = true;
           });
           DB::transaction(function () use ($request, &$createWarranty, $serviceRequest) {
            $createWarranty = ServiceRequestWarrantyIssued::create([
                'service_request_warranty_id'        =>   $serviceRequest->id,
                'cse_id'             =>  $serviceRequest->service_request->cses[0]->account->user_id,
                'technician_id'     =>   NULL,
                'completed_by'      =>   Auth::id(),
                'admin_comment'       =>   Auth::user()->type->url == 'admin'? $request->comment: 'TEST', 
                'cse_comment'       =>  Auth::user()->type->url != 'admin'? $request->comment: '',
                'date_resolved'       =>  \Carbon\Carbon::now('UTC'),
            ]);
            $createWarranty = true;
        });

     
        if ($createWarranty){
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' mark as resolved '.$warrantyExist->name;
            $this->log($type, $severity, $actionUrl, $message);
            if(Auth::user()->type->url == 'admin'){
                return redirect()->route('admin.issued_warranty', app()->getLocale())->with('success', $warrantyExist->name.' warranty has been resolved successfully.');

            }else{
                return redirect()->route('cse.warranty_claims_list', app()->getLocale())->with('success', $warrantyExist->name.' warranty has been resolved successfully.');

            }
        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to mark as resolved '.$warrantyExist->name;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred while trying to delete '.$warrantyExist->name);
        }

         
    }

    public function issuedWarrantiesDetails(Request $request){
        
        return view('cse.requests.show');
    }

    public function warranty_resolved_details(Request $request, $language, $uuid){

        $serviceRequest = ServiceRequestWarranty::where('uuid', $uuid)->with('user.account', 'service_request', 'warranty')->first();
        $warrantyExist = Warranty::where('id',  $serviceRequest->warranty_id)->first();

         //dd( $serviceRequest->service_request_warranty_issued->admin_comment );
        return view('admin.warranty._resolved_details', [
            'serviceRequest'    =>   $serviceRequest,
            'warrantyExist' => $warrantyExist 
        ]);

    }
}
