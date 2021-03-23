<?php

namespace App\Http\Controllers;

use App\Models\State;
use DB;
use Illuminate\Http\Request; 

class EssentialsController extends Controller
{
    public function lgasList(Request $request){
        if($request->ajax()){

            $stateId = $request->get('state_id');

            $stateExists = State::findOrFail($stateId);

            $lgas =  $stateExists->lgas;

            $optionValue = '';
            $optionValue .= "<option value='' selected>Select L.G.A</option>";
            foreach ($lgas as $lga ){

                $optionValue .= "<option value='$lga->id' {{ old('lga_id') == $lga->id ? 'selected' : ''}}>$lga->name</option>";
            }

            $data = array(
                'lgaList' => $optionValue
            );

        }

        return response()->json($data);

    }

    public function getUsersAssigned() {
        // $data = ServiceRequestAssigned::where("user_id", 2)
        $data = DB::table('service_request_assigned')
        // ->join()
        // ->join('accounts', 'service_request_assigned.user_id', '=', 'accounts.user_id')
        // ->where("user_id", 2)
        // ->select('accounts.*', 'service_request_assigned.user_id')
        ->get();
        return $data;
    }
}
