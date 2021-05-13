<?php

namespace App\Http\Controllers\CSE;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Contact;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestAssigned;
use App\Models\User;
use App\Models\CSE;
use Illuminate\Support\Facades\Route;

use App\Traits\Loggable;


class CustomerServiceExecutiveController extends Controller
{
    use Loggable;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cse = ServiceRequestAssigned::where('user_id', $request->user()->id)->with('service_request')->get();
        // Data Needed on dashboard page
        // 1. CSE Ratings
        // 2. CSE Earnings
        return view('cse.index', [
            // 'earnings'
            // 'ratings'
            'completed' => $cse->filter(function ($each) {
                return $each['service_request']['status_id'] == ServiceRequest::SERVICE_REQUEST_STATUSES['Completed'];
            })->count(),
            'canceled' => $cse->filter(function ($each) {
                return $each['service_request']['status_id'] == ServiceRequest::SERVICE_REQUEST_STATUSES['Canceled'];
            })->count(),
            'ongoing' => $cse->filter(function ($each) {
                return $each['service_request']['status_id'] == ServiceRequest::SERVICE_REQUEST_STATUSES['Ongoing'];
            })->count(),
            'available_requests' => CSE::isAvailable() ? ServiceRequest::where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Pending'])->with('service', 'address')->get() : []
        ]);
    }

    /**
     * Accept Service Request Job
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setJobAcceptance(Request $request)
    {
        $request->validate(['service_request_uuid' => 'required|uuid']);
        $acceptedJob = new \App\Http\Controllers\ServiceRequest\JobAcceptanceController(ServiceRequest::where('uuid', $request->service_request_uuid)->firstOrFail(), $request->user());
        return $acceptedJob->cseJobAcceptance();
    }

    /**
     * Accept Service Request Job
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function setAvailablity(Request $request)
    {
        return ($request->user()
            ? (($request->user()->cse->job_availability == CSE::JOB_AVALABILITY[0]
                ? $request->user()->cse->update(['job_availability' => CSE::JOB_AVALABILITY[1]])
                : $request->user()->cse->update(['job_availability' => CSE::JOB_AVALABILITY[0]]))
                ? back()->with('success', 'Availability updated successfully!')
                : back()->with('error', 'Error occured updating availability'))
            : redirect()->route('login'));
    }

    /**
     * Accept CSE Ratings from view and transfer to Ratings Controller for handling
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Controllers\RatingController $ratings
     * 
     * @return \Illuminate\Http\Response
     */
    public function user_rating(Request $request, \App\Http\Controllers\RatingController $ratings)
    {
        return $ratings->handleRatings($request);
    }

    /**
     * Accept CSE Ratings Update from view and transfer to Ratings Controller for handling
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Controllers\RatingController $ratings
     * 
     * @return \Illuminate\Http\Response
     */
    public function update_cse_service_rating(Request $request, \App\Http\Controllers\RatingController $updateRatings)
    {
        return $updateRatings->handleServiceRatings($request);
    }
}
