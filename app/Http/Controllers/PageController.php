<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;
use App\Traits\Services;


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
        return view('frontend.services.show', ['service' => $this->service($uuid)]);
    }

    public function search($language, Request $request){

        //Return all active categories with at least one Service of matched keyword or Category ID
        return view('frontend.services._search', $this->searchKeywords($request));
    }
}
