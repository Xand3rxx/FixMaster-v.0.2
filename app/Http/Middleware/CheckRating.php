<?php

namespace App\Http\Middleware;
use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequestAssigned;

class CheckRating
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
        $output = ServiceRequestAssigned::where('user_id', Auth::id())->with('service_request', 'service_request.users', 'service_request.client', 'service_request.status')
                 ->orderBy('created_at', 'DESC')->get();
                 //dd($output);
        $request->merge(['results' => $output]);
        // dd($request->all());
        return $next($request);
    }
}
