<?php

namespace App\Http\Controllers\ServiceRequest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HandleCompletedDiagnosisController extends Controller
{
    /**
     * Generate Diagnosis Invoice 
     *
     * @param  int  $serviceRequest_id
     * @param  int  $subStatus_id
     * 
     * @return \Illuminate\Http\Response
     */
    public function generateDiagnosisInvoice(int $serviceRequest_id, int $subStatus_id)
    {
        dd($serviceRequest_id, $subStatus_id, 'Isaac Controller');
    }
}
