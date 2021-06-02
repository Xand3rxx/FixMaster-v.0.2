<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicedAreas;
use App\Models\State;
use App\Models\Lga;
use App\Models\Town;
use Illuminate\Http\Request;
use App\Traits\Loggable;
use Illuminate\Support\Facades\Validator; 
use Route;
use Auth;

class ServicedAreasController extends Controller
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

        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')->get();

        $data['lgas'] = Lga::select('id', 'name')->orderBy('name', 'ASC')->get();

        $data['towns'] = Town::select('id', 'name')->orderBy('name', 'ASC')->get();

        $data['serviceAreas'] = ServicedAreas::orderBy('created_at','DESC')->with('state', 'lga', 'town')->get(); 

        // $locationRequest = Location::get();
        // return $data['serviceAreas'];

        return view('admin.serviced_areas.index', $data);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($language, Request $request)
    {
        try{

            //Validate user input fields
            $this->validateRequest();

            //Create record for a new serviced area
            $createServicedAreas = ServicedAreas::create([
                'state_id'       =>  $request->state_id,
                'lga_id'         =>  $request->lga_id,
                'town_id'        =>  $request->town_id,
            ]);

            if( $createServicedAreas ){

                //Record crurrenlty logged in user activity
                $type = 'Others';
                $severity = 'Informational';
                $actionUrl = Route::currentRouteAction();
                $message = Auth::user()->email.' created new service area.';
                $this->log($type, $severity, $actionUrl, $message);
    
                return redirect()->route('admin.seviced-areas.index', app()->getLocale())->with('success', 'new service area was successfully created.');
            }
 
        }catch(exception $e){
 
            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to create new service area.';
            $this->log($type, $severity, $actionUrl, $message);
 
            return back()->with('error', 'An error occurred while trying to create new service area.');
        }
 
    }


    /**
     * Validate user input fields
     */
    private function validateRequest(){
        return request()->validate([
            'state_id'  =>   'required',
            'lga_id'    =>   'required',
            'town_id'   =>   'required', 
        ]);
    }

}
