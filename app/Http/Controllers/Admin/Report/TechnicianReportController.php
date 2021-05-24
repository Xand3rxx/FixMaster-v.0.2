<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceRequestAssigned;
use Auth;

class TechnicianReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.technician.index', [

            'results'   => [],

            'technicians'  =>  \App\Models\Role::where('slug', 'technician-artisans')->with('users')->firstOrFail(),
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

            return view('admin.reports.technician.tables._job_assigned', [
                'results'   =>  ServiceRequestAssigned::jobAssignedSorting($filters)->with('service_request', 'user')
                ->whereHas('user.roles', function ($query){
                    $query->where('slug', 'technician-artisans');
                })->latest('created_at')->get()
            ]);

        }
    }

}
