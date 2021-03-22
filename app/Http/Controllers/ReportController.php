<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Auth;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\Service;
use App\Models\Report;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestStatus;
use App\Models\ServiceRequestCancellation;
use App\Models\ServiceRequestAssigned;
use App\Models\Account;
use App\Models\UserType;
use App\Models\Category;



class ReportController extends Controller
{
    public function cseReports()
    {



         //Return all services,including inactive ones
         $services = Service::Servicies()->get();

         //Return all active categories
         $categories = Category::ActiveCategories()->get();
 
         $data = [
             'services'      =>  $services,
             'categories'    =>  $categories,
         ];
 
         //return view('admin.service.index', $data)->with('i');

        
        /*$services = Service::orderBy('created_at', 'DESC')->get();
       
        $message = '';

        
        $yearList = array();

        $years = Service::orderBy('created_at', 'ASC')->pluck('created_at');

        

        //Collate collections to $data array
        $data = [
            
            'message'       =>  $message,
            'years'         =>  $years,
            'services'      => $services,
            
        ];*/
       
       return view('admin.reports.cse_reports', $data)->with('i');
        //return view('admin.reports.cse_reports', compact('data'));
    }



    public function sortCSEReports($language, Request $request){

        // return $request->user;

        if($request->ajax()){

            //Get User ID
            $userId = $request->get('user');
            //Get current activity sorting level
            $level =  $request->get('sort_level');
          
            //Get activity log for a specific date
            $specificDate =  $request->get('date');
            //Get activity log for a specific year
            $specificYear =  $request->get('year');
            //Get activity log for a specific month
            $specificMonth =  date('m', strtotime($request->get('month')));
            //Get activity log for a specific month name
            $specificMonthName =  $request->get('month');
            //Get activity log for a date range
            $dateFrom =  $request->get('date_from');
            $dateTo =  $request->get('date_to');

            //Verify if user exists on `users` table
            // $userExists = User::findOrFail($userId);
        
            if($level === 'Level One'){

                $activityLogs = ServiceRequest::where('type', $type)
                ->orderBy('created_at', 'DESC')->get();
                
                
                $requestAssigned = ServiceRequestAssigned::orderBy('created_at', 'DESC')->get();

                $message = 'Showing Report of "'.$type.'"';

                $data = [
                    'activityLogs'  =>  $activityLogs,
                    'message'       =>  $message,
                    'requestAssigned' =>  $requestAssigned,
                ];

                //return view('admin.reports.report_table', $data)->with('i');
                return view('admin.reports.report_table', compact('data'));

            }

            if($level === 'Level Two'){

                if(($type !== 'None') && !empty($specificDate)){
                    $activityLogs = ServiceRequest::where('type', $type)
                    ->whereDate('created_at', $specificDate)
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Report of "'.$type.'" report for '.\Carbon\Carbon::parse($specificDate, 'UTC')->isoFormat('LL');
                }
                
                if(($type == 'None') && !empty($specificDate)){
                    $activityLogs = ServiceRequest::whereDate('created_at', $specificDate)
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Report for '.\Carbon\Carbon::parse($specificDate, 'UTC')->isoFormat('LL');
                }

                $data = [
                    'activityLogs'  =>  $activityLogs,
                    'message'       =>  $message,
                ];

                return view('admin.reports.report_table', compact('data'));

            }

            if($level === 'Level Three'){
                if(($type !== 'None') && !empty($specificYear)){
                    $activityLogs = ServiceRequest::where('type', $type)
                    ->whereYear('created_at', $specificYear)
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Report of "'.$type.'" report for year '.$specificYear;
                }
                
                if(($type == 'None') && !empty($specificYear)){
                    $activityLogs = ServiceRequest::whereYear('created_at', $specificYear)
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Report for year '.$specificYear;
                }

                $data = [
                    'activityLogs'  =>  $activityLogs,
                    'message'       =>  $message,
                ];

                return view('admin.reports.report_table', compact('data'));
            }

            if($level === 'Level Four'){
                
                if(($type !== 'None') && !empty($specificYear) && !empty($specificMonth)){
                    $activityLogs = ServiceRequest::where('type', $type)
                    ->whereYear('created_at', $specificYear)
                    ->whereMonth('created_at', $specificMonth)
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Report of "'.$type.'" report for "'.$specificMonthName.'" in year '.$specificYear;
                }
                
                if(($type == 'None') && !empty($specificYear) && !empty($specificMonth)){
                    $activityLogs = ServiceRequest::whereYear('created_at', $specificYear)
                    ->whereMonth('created_at', $specificMonth)
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Report for "'.$specificMonthName.'" in year '.$specificYear;
                }

                $data = [
                    'activityLogs'  =>  $activityLogs,
                    'message'       =>  $message,
                ];

                return view('admin.reports.report_table', compact('data'));
            }
            
            if($level === 'Level Five'){

                if(($type !== 'None') && !empty($dateFrom) && !empty($dateTo)){
                    $activityLogs = ServiceRequest::where('type', $type)
                    ->whereBetween('created_at', [$dateFrom, $dateTo])
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Report of "'.$type.'" report type from "'.\Carbon\Carbon::parse($dateFrom, 'UTC')->isoFormat('LL').'" to "'.\Carbon\Carbon::parse($dateTo, 'UTC')->isoFormat('LL').'"';
                }
                
                if(($type == 'None') && !empty($dateFrom) && !empty($dateTo)){
                    $activityLogs = ServiceRequest::whereBetween('created_at', [$dateFrom, $dateTo])
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Report from "'.\Carbon\Carbon::parse($dateFrom, 'UTC')->isoFormat('LL').'" to "'.\Carbon\Carbon::parse($dateTo, 'UTC')->isoFormat('LL').'"';
                }

                $data = [
                    'activityLogs'  =>  $activityLogs,
                    'message'       =>  $message,
                ];

                return view('admin.reports.report_table', compact('data'));
            }

        }
    }

    public function cseReportDetails($language, $id){

        //Get single activity log detail
        $activityLogDetails = ServiceRequest::findOrFail($id);

        //Get first name
        $firstName = $activityLogDetails->account->first_name ?? 'UNAVAILABLE'; 

        //Get last name
        $lastName = $activityLogDetails->account->last_name ?? ''; 

        //Concatenate first name and last name to create full name
        $fullName = $firstName.' '.$lastName;

        // $designation =  $activityLogDetails->type->role->name;
        $designation =  UserType::where('user_id', $activityLogDetails->user_id)->first()->role->name;

        $data = [
            'activityLogDetails'    =>  $activityLogDetails,
            'fullName'              =>  $fullName,
            'designation'           =>  $designation,
        ];

        return view('admin.reports.report_details', $data);
    }
}
