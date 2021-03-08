<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Service;

class ClientController extends Controller
{


    //call the profile page with credentials
    public function edit_profile(Request $request)
    {

    }

    public function update_profile(Request $request)
    {
      
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request){


    }

    public function view_profile(Request $request){
       

    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $popularRequests = Service::select('id', 'name', 'url', 'image')->take(10)->get()->random(3);
        
        return view('client.home', [
            // data
            'totalRequests' => rand(1, 1),
            'completedRequests' => rand(1, 1),
            'cancelledRequests' => rand(1, 1),
            'user' => auth()->user()->account,
            'client' => [
                'phone_number' => '0909078888'
            ],
            'popularRequests'   =>  $popularRequests,
            // JoeBoy Fill this data
            // 1. 'userServiceRequests'
            // 2. 'popularRequests'
            // 3. 'cseName'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
