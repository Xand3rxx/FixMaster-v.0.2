<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Traits\Utility;
use App\Models\Warranty;
use App\Models\ServiceRequestWarranty;
use Illuminate\Support\Facades\URL;
use App\Traits\Loggable;
use App\Models\PaymentDisbursed;

use Auth;
use Route;
use DB;

class WarrantyController extends Controller
{
    use Loggable;
    use Utility;
    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    public function __construct() {
        $this->middleware('auth:web');
    
    }

    public function index()
    {
        //Return all warranty
        $warranty = Warranty::get();
        
        //Append collections to $data array
        $data = [
            'warranties' =>  $warranty
        ];

        return view('admin.warranty.index', $data)->with('i');
    }

   

    public function storeWarranty($language, Request $request)
    {
        

              //Validate user input fields
            $request->validate([
                'name'          =>   'required',
                'percentage'    =>   'required',
                'warranty_type'    =>   'required',
                'duration'    =>   'required',
                'description'   =>   'required', 
            ]);

            
            $createWarranty = Warranty::create([
                'user_id'        =>  Auth::id(),
                'name'           => $request->name,
                'percentage'     =>   $request->percentage,
                'warranty_type'  =>   $request->warranty_type,
                'duration'       =>   $request->duration, 
                'description'    =>   $request->description,
            ]);


            if($createWarranty){

               
                $type = 'Others';
                $severity = 'Informational';
                $actionUrl = Route::currentRouteAction();
                $message = Auth::user()->email.' saved '.ucwords($request->input('name')).' warranty';
                $this->log($type, $severity, $actionUrl, $message);
    
                return redirect()->route('admin.warranty_list', app()->getLocale())->with('success', ucwords($request->input('name')).' warranty created successfully.');
    
            }else{
                
                $type = 'Errors';
                $severity = 'Error';
                $actionUrl = Route::currentRouteAction();
                $message = 'An error occurred while '.Auth::user()->email.' was trying to create warranty.';
                $this->log($type, $severity, $actionUrl, $message);
    
                return back()->with('error', 'An error occurred while trying to create '.ucwords($request->input('name')).' Warranty.');
            }
    
            return back()->withInput();
               
    }

    /**
     * Validate user input fields
     */
    private function validateRequest(){
        return request()->validate([
            'warranty_name' =>   'required|unique:warranty,name',
            'percentage'    =>   'required|numeric',
            'warranty_type' =>   'required', 
            'description'   =>   'required', 
        ]);
    }

    public function show($language, $details)
    {
        //Select the warranty based on the uuid
       
        $warranty = Warranty::where('uuid', $details)->firstOrFail();

      

        //Append variables & collections to $data array
        $data = [
            'warranty'       =>  $warranty,
        ];

        //Return $data to partial cateogory view
        return view('admin.warranty.warranty_details', $data)->with('i');
    }

    public function edit($language, $details)
    {
        $warranty = Warranty::where('uuid', $details)->firstOrFail();

        $data = [
            'warranty'       =>  $warranty,
        ];

        return view('admin.warranty.edit_warranty', $data);
    }

    public function update($language, $details, Request $request)
    {
        //Validate user input fields
        $request->validate([
            'name'          =>   'required',
            'percentage'    =>   'required',
            'warranty_type' =>   'required',
            'duration'      =>   'required',
            'description'   =>   'required', 
        ]);


        //Update Warranty
        $updateWarranty= Warranty::where('uuid', $details)->update([
            'name'          =>   ucwords($request->name),
            'percentage'    =>   $request->percentage,
            'warranty_type'    =>   $request->warranty_type,
            'description'   =>   $request->description,
        ]);
        
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

            return back()->with('error', 'An error occurred while trying to update '.ucwords($request->input('name')).' Warranty.');
        }

        return back()->withInput();
    }

    //This method delete already created warranty
    public function deleteWarranty($language, $details)
    {
        $warrantyExist = Warranty::where('uuid', $details)->first();

        $softDeleteWarranty = $warrantyExist->delete();
        if ($softDeleteWarranty){
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$warrantyExist->name;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.warranty_list', app()->getLocale())->with('success', 'Warranty has been deleted successfully');
        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to delete '.$details->name;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }


    public function warrantyTransactionSort(Request $request)
    {
       

            // $user = Auth::user();
            // $payments = $user->payments();
            $years =  $this->getDistinctYears($tableName = 'warranty_payments'); 
    
            //$payments = WarrantyPayment::where('recipient_id',Auth::id())
            //->orderBy('created_at', 'DESC')->get();
            $warranties = ServiceRequestWarranty::with('user', 'user.account')->get();

            return view('admin.warranty.warranty_sort', compact('years', 'warranties',));
    }

    public function warrantyTransaction()
    {

        //return view('admin.users.cse.index')->with([
          //  'users' => \App\Models\Cse::with('user', 'user.account', 'user.contact', 'user.roles')->withCount('service_request_assgined')->get(),
        //]);
        $warranty = ServiceRequestWarranty::with('user', 'user.account')->get();
        

        //Append collections to $data array
        $data = [
            'warranties' =>  $warranty
        ];

        return view('admin.warranty.warranty_transaction', $data)->with('i');
    }

}
