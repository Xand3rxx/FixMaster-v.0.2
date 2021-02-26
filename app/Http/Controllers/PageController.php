<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $states = State::all();
        return view('frontend.careers.index', compact('states'));
    }
}
