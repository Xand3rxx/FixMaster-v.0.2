<?php

namespace App\Http\Middleware;
use Closure;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequestAssigned;
use App\Models\ServiceRequest;

class CheckClientRating
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $output = ServiceRequest::where('client_id', Auth::id())->get();
        //with('service_request', 'service_request.users', 'service_request.client', 'service_request.status', 'service_request.users.account', 'service_request.users.roles')->get();

        //    foreach ($output as $out) {
        //        $res = $out->service_request->status->name;
        //        $dat = $out->service_request->users;
        //        $serviceRequestClient = $out->service_request->clientAccount;
        //        $serviceRequestId = $out->service_request->id;
        //        foreach ($dat as $user) {
        //            $data = $user->roles;

        //            foreach ($data as $role) {
        //                $response = $role->id;
        //             }
               // }
                       //if ($res == 'Ongoing') {
                           $request->merge(['results' => $output]);
                      // }

                    //    if ($res == 'Completed' && $out->service_request->has_client_rated == "Skipped" && $out->service_request->updated_at < Carbon::now()->subMinutes(1)) {
                    //     $request->merge(['results' => $res, 'users' => $dat, 'client' => $serviceRequestClient, 'serviceRequestId' => $serviceRequestId]);
                    // }

                  // }

        return $next($request);
    }
}
