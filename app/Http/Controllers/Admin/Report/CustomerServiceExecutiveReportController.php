<?php

namespace App\Http\Controllers\Admin\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerServiceExecutiveReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return \App\Models\Role::where('slug', 'cse-user')->with('users')->firstOrFail();

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
    public function jobAssignedSorting($language, Request $request){
        if($request->ajax()){

            //Get current job assigned sorting level
            $sortingLevel =  $request->sort_level;

            if($sortingLevel === 'SortType1'){

                return 'It is working';
            }
        }
    }
}
