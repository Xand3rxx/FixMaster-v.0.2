<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequestAssigned;

class CustomerServiceExecutiveReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return ServiceRequestAssigned::with('service_request', 'user')->get();
        return view('admin.reports.cse.index', [
            'results'   => ServiceRequestAssigned::with('service_request', 'user')->get(),
            'cses'  =>  \App\Models\Role::where('slug', 'cse-user')->with('users')->firstOrFail(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * This is an ajax call to CSE Job Assigned Report
     * present on change of sorting parameter select dropdown
     */
    public function jobAssignedSorting($language, Request $request)
    {
        if ($request->ajax()) {
            (array) $filters = $request->only('cse_id', 'job_status', 'sort_level', 'date');

            //Assign job status ID to a variable
            $jobStatus = $filters['job_status'];

            //IF job status id is sent as a parameter search `service_requests` table
            // if(!empty($jobStatus)){

            //      return view('admin.reports.cse.tables._job_assigned', [
            //         'results'   =>  ServiceRequestAssigned::with(['service_request', 'user'])
            //         ->whereHas('service_request', function ($query) use ($jobStatus) { 
            //             $query->where('status_id', $jobStatus);
            //          })->get()
            //     ]);
                 
            // }else{
                return view('admin.reports.cse.tables._job_assigned', [
                    'results'   =>  ServiceRequestAssigned::jobAssignedSorting($filters)->with('service_request', 'user')->get()
                ]);
            // }
            
        }
    }
}
