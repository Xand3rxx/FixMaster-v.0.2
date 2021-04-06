<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Auth;
use Route;
use DB;

use App\Traits\Loggable;
use App\Models\SubStatus;

class StatusController extends Controller
{
    use Loggable;
    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    public function __construct() {
        $this->middleware('auth:web');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Return all Sub Statuses, including inactive ones
        $subStatuses = SubStatus::SubStatuses()->get();

        return view('admin.sub_statuses.index', [
            'subStatuses'   =>  $subStatuses
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
        $lastPhase = (int) SubStatus::select('phase')->where('status_id', 2)->latest()->first()->phase;

        //Validate user input fields
        $request->validate([
            'name'              =>   'required',
            'recurrence'        =>   'required|in:Yes,No',
        ]);

        DB::transaction(function () use ($request, $lastPhase, &$createSubStatus) {

            SubStatus::create([
                'user_id'       =>  Auth::id(),
                'name'          =>  $request->name,
                'status_id'     =>  2, //Default the parent status to Ongoing 
                'phase'         =>  $lastPhase + 1,
                'recurrence'    =>  $request->recurrence,
                'status'        =>  'active', //Default the status to active
            ]);

            $createSubStatus = true;

        });

        if($createSubStatus){

            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' updated '.ucwords($request->input('name')).' sub-status';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.statuses.index', app()->getLocale())->with('success', ucwords($request->input('name')).' sub-status was successfully updated.');

        }else{
            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to update sub-status.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to update '.ucwords($request->input('name')).' sub-status.');
        }

        return back()->withInput();


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $uuid)
    {

        return view('admin.sub_statuses._edit', [
            'subStatus' => SubStatus::where('uuid', $uuid)->firstOrFail()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($language, Request $request, $uuid)
    {
        $updateSubStatus = SubStatus::where('uuid', $uuid)->firstOrFail();

        $request->validate([
            'name'              =>   'required',
            'recurrence'        =>   'required|in:Yes,No',
        ]);

        DB::transaction(function () use ($request, $uuid, $updateSubStatus, &$createSubStatus) {

            $updateSubStatus = SubStatus::where('uuid', $uuid)->update([
                'user_id'       =>  Auth::id(),
                'name'          =>  $request->name,
                'status_id'     =>  $updateSubStatus->status_id,
                'recurrence'    =>  $request->recurrence,
            ]);

            $updateSubStatus = true;

        });

        if($updateSubStatus){

            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' updated '.ucwords($request->input('name')).' sub-status';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.statuses.index', app()->getLocale())->with('success', ucwords($request->input('name')).' sub-status was successfully updated.');

        }else{
            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to update sub-status.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to update '.ucwords($request->input('name')).' sub-status.');
        }

        return back()->withInput();

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($language, $uuid)
    {
        //Verify if uuid exists
        $SubStatus = SubStatus::where('uuid', $uuid)->firstOrFail();

        $deleteSubStatus = $SubStatus->delete();

        if($deleteSubStatus){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$SubStatus->name.' sub-status';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('success', $SubStatus->name. ' sub-status has been deleted.');
            
        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to delete '.$SubStatus->name.' sub-status.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to delete '.$SubStatus->name);
        } 
    }
    
    public function deactivate($language, $uuid)
    {
        //Get SubStatus record
        $SubStatus = SubStatus::where('uuid', $uuid)->firstOrFail();

        //Update SubStatus status to inactive
        $deactivateSubStatus = SubStatus::where('uuid', $uuid)->update([
            'status'    => 'inactive'
        ]);

        if($deactivateSubStatus){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deactivated '.$SubStatus->name.' sub-status';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.statuses.index', app()->getLocale())->with('success', $SubStatus->name.' sub-status has been deactivated.');
            
        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to deactivate '.$SubStatus->name.' sub-status.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to deactivate sub-status.');
        } 
        
    }

    public function reinstate($language, $uuid)
    {
        //Get SubStatus record
        $SubStatus = SubStatus::where('uuid', $uuid)->firstOrFail();

        //Update SubStatus status to active
        $reinstateSubStatus = SubStatus::where('uuid', $uuid)->update([
            'status'    => 'active'
        ]);

        if($reinstateSubStatus){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' reinstated '.$SubStatus->name.' SubStatus';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.statuses.index', app()->getLocale())->with('success', $SubStatus->name.' sub-status has been reinstated.');
            
        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to reinstate '.$SubStatus->name.' sub-status.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to reinstate sub-status.');
        } 
    }
}
