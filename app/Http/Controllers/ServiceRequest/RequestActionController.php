<?php

namespace App\Http\Controllers\ServiceRequest;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;

class RequestActionController extends Controller
{
    /**
     * Handle the incoming request for service request action.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string $locale
     * @param  \App\Models\ServiceRequest $service_request
     * 
     * @return \Illuminate\Http\Response
     */
    public function incoming(Request $request, string $locale, ServiceRequest $service_request)
    {
        if ($request->hasAny(['add_comment', 'email'])) {
            $action = new \App\Http\Controllers\ServiceRequest\Concerns\RepeatedActions($request, $service_request);
            return $action->handle();
        }

        return dd([$request->all(), $service_request], 'requet');
    }
}
