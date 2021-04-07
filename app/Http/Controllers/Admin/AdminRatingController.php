<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminRatingController extends Controller
{
    public function cseDiagnosis(Request $request){
        $diagnosisRatings = Rating::where('service_diagnosis_by', '!=', null)->with('clientAccount', 'cseAccount','service_request')->get();
        //return dd($cse);
        return view('admin.ratings.cse_diagnosis_rating', compact('diagnosisRatings'));
    }

    public function getServiceRatings(Request $request)
    {

            $cards = Rating::select([
                'service_id',
                \DB::raw('COUNT(id) as id'),
                \DB::raw('AVG(star) as starAvg')
            ])
            ->where('service_request_id', null)
            ->where('service_diagnosis_by', null)
            ->where('ratee_id', '!=', null)
                ->groupBy('service_id')->get();

        return view('admin.ratings.service_rating', compact('cards'));
    }
}