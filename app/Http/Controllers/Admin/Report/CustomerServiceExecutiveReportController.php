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
        return view('admin.reports.cse.index', [
            'cses'  =>  \App\Models\Role::where('slug', 'cse-user')->with('users')->firstOrFail(),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     *
     * This is an ajax call to sort all CSE's assigned to a service request
     * present on change of Sortung Parameter select dropdown
     */
    public function jobAssignedSorting($language, Request $request)
    {
        if ($request->ajax()) {
            (array) $filters = $request->only('cse_id', 'job_status', 'sort_level', 'date');
            // return $filters['date']['date_from'];
            return ServiceRequestAssigned::filter($filters)->get();

            //Get current job assigned sorting level
            // $sortLevel = $request->sort_level;
            // //Get cse id's array
            // $cses = $request->cse_id;
            // //Get Date from
            // $dateFrom = $request->date_from;
            // //Get Date to
            // $dateTo = $request->date_to;
            // //Get Job status Id
            // $jobStatus = $request->job_status;
            // return $cses;
            // return [$sortLevel, $cses, $dateFrom, $dateTo];
            // return ServiceRequestAssigned::jobAssignedSorting($sortLevel, $dateFrom, $dateTo, $cses)->get();
        }
    }
}
