<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Models\Warranty;
use Illuminate\Support\Facades\URL;
use App\Traits\Loggable;
use Auth;
use Route;
use DB;

class WarrantyController extends Controller
{
    use Loggable;
    
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
        //dd ($warranty);

        //Append collections to $data array
        $data = [
            'warranties' =>  $warranty
        ];

        return view('admin.warranty.index', $data)->with('i');
    }

    public function store($language, Request $request)
    {
        try{

            //Validate user input fields
            $this->validateRequest();

            
            $createWarranty = Warranty::create([
                'user_id'        =>  Auth::id(),
                'name'      => $request->warranty_name,
                'amount'    =>   $request->amount,
                'warranty_type'    =>   $request->warranty_type,
                //'duration'    =>   $request->duration, 
                'description'   =>   $request->description,
            ]);

         

            if($createWarranty){

              
                $type = 'Others';
                $severity = 'Informational';
                $actionUrl = Route::currentRouteAction();
                $message = Auth::user()->email.' created '.ucwords($request->input('name')).' warranty.';
                $this->log($type, $severity, $actionUrl, $message);
    
                return redirect()->route('admin.warranty.index', app()->getLocale())->with('success', ucwords($request->name).' warranty was successfully created.');
            }
 
        }catch(exception $e){
 
           
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to create a new warranty.';
            $this->log($type, $severity, $actionUrl, $message);
 
            return back()->with('error', 'An error occurred while trying to create a new warranty.');
        }
 
    }

    /**
     * Validate user input fields
     */
    private function validateRequest(){
        return request()->validate([
            'warranty_name'          =>   'required|unique:warranty,name',
            'amount'    =>   'required|numeric',
            'warranty_type'    =>   'required', 
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
            
            'description'   =>   '', 
        ]);


        //Update Warranty
        $updateWarranty= Warranty::where('uuid', $details)->update([
            'name'          =>   ucwords($request->name),
            'amount'    =>   $request->percentage,
            
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

    public function warrantyTransaction()
    {
        $warranty = Warranty::get();
        //dd ($warranty);

        //Append collections to $data array
        $data = [
            'warranties' =>  $warranty
        ];

        return view('admin.warranty.warranty_transaction', $data)->with('i');
    }

}
