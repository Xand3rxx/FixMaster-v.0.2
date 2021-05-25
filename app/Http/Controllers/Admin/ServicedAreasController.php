<?php

namespace App\Http\Controllers\Admin;
use App\Models\ServicedAreas;
use Illuminate\Http\Request;

class ServicedAreasController extends Controller
{
    public function index()
    {
        $data['serviceRequests'] = ServicedAreas::get(); 
                                    
        // $locationRequest = Location::get();

        return view('admin.serviced.areas', $data);

    }
}
