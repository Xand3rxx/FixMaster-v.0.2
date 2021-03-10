<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Traits\Loggable;

class TechnicianProfileController extends Controller
{
    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    public function __construct() {
        $this->middleware('auth:web');
    }

    /**
     * Return Technician Dashboard
     */
    public function index(){

        return view('technician.index')->with('i');
    }

    /**
     * Return Location Request Page 
     */
    public function locationRequest(){

        return view('technician.location_request')->with('i');
    }

    /**
     * Return Payments Page 
     */
    public function payments(){

        return view('technician.payments')->with('i');
    }

    /**
     * Return Service Requests Page 
     */
    public function serviceRequests(){

        return view('technician.requests')->with('i');
    }

    /**
     * Return Service Requests Details Page 
     */
    public function serviceRequestDetails($language){

        return view('technician.request_details')->with('i');
    }

    
    
}
