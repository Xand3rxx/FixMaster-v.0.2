<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rating;

class AdminRatingController extends Controller
{
    public function cseDiagnosis(Request $request){
        $diagnosisRatings = Rating::where('service_diagnosis_by', '!=', null)->with('clientAccount', 'cseAccount','service_request')->get();
        //return dd($cse);
        return view('admin.ratings.cse_diagnosis_rating', compact('diagnosisRatings'));
    }

    public function getServiceRatings(Request $request)
    {
        $resviceRatings = Rating::where('service_request_id', '!=', null)
            ->where('service_diagnosis_by', null)
            ->where('ratee_id', null)->get();
        return view('admin.ratings.service_rating', compact('resviceRatings'));
    }
}
