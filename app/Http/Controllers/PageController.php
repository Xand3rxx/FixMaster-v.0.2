<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Service;

class PageController extends Controller
{
    public function index()
    {
        $states = State::all();
        return view('frontend.careers.index', compact('states'));
    }

    public function services(){

        $categories = Category::ActiveCategories()->get();

        $services = Category::ActiveCategories()
        ->where('id', '!=', 1)
        ->orderBy('name', 'ASC')
        ->with(['services'    =>  function($query){
            return $query->select('name', 'uuid', 'image', 'category_id');
        }])
        ->has('services')->get();

        // return $services;

        return view('frontend.services.index')->with([
            'categories'    =>  $categories,
            'services'    =>  $services
        ]);
    }

    public function serviceDetails($language, $uuid){

        $service = Service::findOrFail($uuid);
        
        return view('client.service_details')->with([
            'service'   =>  $service
        ]);
    }
}
