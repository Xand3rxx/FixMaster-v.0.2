<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestAssigned; 
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

    public function getServiceDetails(Request $request){
        // $serviceRequests = ServiceRequestAssigned::where('user_id', 1)->with('service_request')->get();
        $serviceRequests = ServiceRequest::with('serviceRequestAssigned')->get();
        return $serviceRequests;
    }

    public function getAvailableToolQuantity(Request $request){
        if($request->ajax()){
            $toolId = $request->get('tool_id');

            $toolExists = \App\Models\ToolInventory::findOrFail($toolId);

            $availableQuantity =  $toolExists->available;

            return $availableQuantity;
        }
    }
    public function Edit($id){
        $data = ServiceRequestSettingController::find($id);
        return $data;
      }
}
