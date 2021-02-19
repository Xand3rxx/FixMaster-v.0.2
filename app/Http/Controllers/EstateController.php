<?php

namespace App\Http\Controllers;

use App\Models\Estate;
use App\Models\State;
use Illuminate\Http\Request;

class EstateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estates = Estate::select('id', 'estate_name', 'first_name', 'last_name', 'email', 'phone_number', 'state_id', 'lga_id', 'is_active', 'slug', 'created_at')
            ->orderBy('estates.estate_name', 'ASC')
            ->latest('estates.created_at')
            ->get();

        $i = 0;
        return view('admin.estate.list', compact('estates','i'));
    }

    public function showEstates()
    {
        $estates = Estate::select('id', 'estate_name', 'first_name', 'last_name', 'email', 'phone_number', 'state_id', 'lga_id', 'is_active', 'slug', 'created_at')
            ->orderBy('estates.estate_name', 'ASC')
            ->latest('estates.created_at')
            ->get();

        return $estates;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states = State::all();
        return response()->view('admin.estate.add', compact('states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate input
        $this->validateRequest();

        //Create new estate record
        $estate = Estate::create([
            'state_id' => $request->input('state_id'),
            'lga_id' => $request->input('lga_id'),
            'first_name' => $request->input('first_name'),
            'middle_name' => $request->input('middle_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone_number' => $request->input('phone_number'),
            'date_of_birth' => $request->input('date_of_birth'),
            'identification_type' => $request->input('identification_type'),
            'identification_number' => $request->input('identification_number'),
            'expiry_date' => $request->input('expiry_date'),
            'full_address' => $request->input('full_address'),
            'estate_name' => $request->input('estate_name'),
            'town' => $request->input('town'),
            'is_active' => '0',
            'slug' => \Str::slug($request->input('estate_name'))
        ]);
        if($estate) {
            return redirect()->route('admin.list_estate', app()->getLocale())->with('success', 'Estate has been added successfully');
        } else {
            return redirect()->route('admin.create_estate', app()->getLocale())->with('error', 'An error occurred');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function estateSummary($language, Estate $estate)
    {
        dd($language, $estate);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function edit(Estate $estate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Estate $estate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Estate  $estate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estate $estate)
    {
        //
    }

    private function validateRequest() {
        return request()->validate([
            'state_id'              => 'required',
            'lga_id'                => 'required',
            'first_name'            => 'required',
            'middle_name'           => '',
            'last_name'             => 'required',
            'email'                 => 'required|email|unique:estates,email',
            'phone_number'          => 'required|Numeric|unique:estates,phone_number',
            'date_of_birth'         => 'required',
            'identification_type'   => 'required',
            'identification_number' => 'required',
            'expiry_date'           => 'required',
            'full_address'          => 'required',
            'estate_name'           => 'required',
            'town'                  => 'required'
        ]);
    }

    public function showActiveEstates()
    {
        //Get all the active estates from the db
        $activeEstates = Estate::select('id', 'estate_name')
        ->orderBy('estates.estate_name', 'ASC')
        ->where('estates.is_active', '1')
        ->get();
        return $activeEstates;

    }
}
