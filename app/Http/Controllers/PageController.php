<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Rating;
use App\Models\Review;
use App\Traits\Services;
use Illuminate\Http\Request;


class PageController extends Controller
{
    use Services;

    public function index()
    {
        $states = State::all();
        return view('frontend.careers.index', compact('states'));
    }

    public function services(){

        //Return all active categories with at least one Service
        return view('frontend.services.index', $this->categoryAndServices());
    }

    public function serviceDetails($language, $uuid){
        //Return Service details
        $service = $this->service($uuid);
        $rating = Rating::where('service_id', $service->id)
                    ->where('service_request_id', null)
                    ->where('service_diagnosis_by', null)
                    ->where('ratee_id', '!=', null)->get();
        $reviews = Review::where('service_id', $service->id)->where('status', 1)->get();
        return view('frontend.services.show', compact('service','rating','reviews'));
    }

    public function search($language, Request $request){

        //Return all active categories with at least one Service of matched keyword or Category ID
        return view('frontend.services._search', $this->searchKeywords($request));
    }
}
