<?php

namespace App\Http\Controllers\ServiceRequest;

use Auth;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use App\Traits\findRecordWithUUID;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Traits\Utility;
use App\Traits\ImageUpload;
use Image;


class WarrantClaimController extends Controller
{
    use findRecordWithUUID, Loggable, Utility, ImageUpload;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function assignWarrantyTechnician(Request $request){


        $this->validate(
            $request, 
            ['preferred_time' => 'required_if:service_request_warrant_issued_schedule_date,==,null'],
            ['required_if' => 'This scheduled fix date is required'],
        );

       
        // if($request->intiate_rfq == 'yes'){
        //     $this->validate($request, [
        //         'image'                     => 'required|array|min:1',
        //         'component_name'            => 'required|array|min:1',
        //         'model_number'              => 'required|array',
        //     ]);
        //   }
    
   
        $service_request_warranty_id = $request['service_request_warranty_id'];
        $serviceRequest = \App\Models\ServiceRequestWarrantyIssued::where('service_request_warranty_id', $request['service_request_warranty_id'])->first();
     
     
       $done = $this->save($serviceRequest, $service_request_warranty_id,$request);

        if (  $done){
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' Warranty Claim Updated successfully ';
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('success','Warranty Claim Updated successfully');

        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to update warranty claim ';
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred while trying to update warranty claim ');
        }
    

   
    }


    protected function save($serviceRequest, $service_request_warranty_id,$request ){

        if($request->preferred_time){
  
        $upload='1'; $comment='1';
        if($serviceRequest){
            $updateWarranty = \App\Models\ServiceRequestWarrantyIssued::where('service_request_warranty_id', $service_request_warranty_id)->update([
                    'service_request_warranty_id'     =>   $request['service_request_warranty_id'],
                  'scheduled_datetime' => $request->preferred_time,  
                ]);
        }
    }


    if($request['technician_user_uuid'] ){
         $updateTecnician = $this->saveTechnician($serviceRequest, $service_request_warranty_id,$request);
        }


        $serviceRequestIssued = $serviceRequest;

         //dd($serviceRequestIssued);
    

        if($request->hasFile('upload_image')) 
            $upload = $this->upload_image($request,$serviceRequestIssued);
        else
           $upload = '1';


        

        if($request->causal_reason || $request->causal_agent_id) 
           $comment =  $this->diagnosticWarrantReport($request,$serviceRequestIssued);
        else
           $comment =  '1';

           if($request->cse_comment) 
           $report =  $this->serviceRequestReport($request,$serviceRequestIssued);
        else
           $report =  '1';

        if($request->intiate_rfq == 'yes')

            $done = $this->saveRfq($request);
        else
           $done = '1';    
        
      
        if($upload  AND $comment AND $done AND $report){
            return true;

        }else{
            return false; 
        }
        
    }

    protected function upload_image($request,$serviceRequesIssued){
        foreach ($request->file('upload_image') as $file) {
            $image = $file;
            $imageName = (string) Str::uuid() .'.'.$file->getClientOriginalExtension();
            $imageDirectory = public_path('assets/warranty-claim-images').'/';
            $width = 350; $height = 259;
            Image::make($image->getRealPath())->resize($width, $height)->save($imageDirectory.$imageName);

            $createWarranty = \App\Models\ServiceRequestWarrantyImage::create([
                'user_id'                                         =>  Auth::id(),
                'service_request_warranties_issued_id'             =>  $serviceRequesIssued->id,
                'name'                                             =>   $imageName,
                
            ]);
    
        }
        return  $createWarranty ;
    }


    protected function diagnosticWarrantReport($request,$serviceRequesIssued){

        if($request->causal_agent_id){
        foreach ($request->causal_agent_id as $value) {
        $createWarranty = \App\Models\ServiceRequestWarrantyReport::create([
            'user_id'                                         =>  Auth::id(),
            'service_request_warranties_issued_id'             =>  $serviceRequesIssued->id,
            'report'                                           =>  $request->cse_comment?? 'none',
            'causal_agent_id'                                  =>   $value,
            'causal_reason'                                    =>   $request->causal_reason??'None',
            
        ]);

      }
    }else{
        $createWarranty = \App\Models\ServiceRequestWarrantyReport::create([
            'user_id'                                         =>  Auth::id(),
            'service_request_warranties_issued_id'             =>  $serviceRequesIssued->id,
            'report'                                           =>   $request->cse_comment?? 'none',
            'causal_agent_id'                                  =>   '0',
            'causal_reason'                                    =>   $request->causal_reason??'None',
            
        ]);
    }
    
        return  $createWarranty ;
    }


    protected function serviceRequestReport($request,$serviceRequesIssued){
        $createReport = \App\Models\ServiceRequestReport::create([
            'user_id'                                         =>  Auth::id(),
            'service_request_id'             =>  $request->service_request_id,
            'report'                                   =>   $request->cse_comment,
            'stage'                                  =>   'Warranty-Claim',
            'type '                                    =>   'Root-Cause',
            
        ]);

        return  $createReport ;
    }


    public function uploadImage($file)
    {
        
            $image = $file;
            $imageName = (string) Str::uuid() .'.'.$file->getClientOriginalExtension();
            $imageDirectory = public_path('assets/warranty-claim-images').'/';
            $width = 350; $height = 259;
            Image::make($image->getRealPath())->resize($width, $height)->save($imageDirectory.$imageName);


        return  $imageName ;
    }


    public function saveRfq($request){


        $component_name = [];
        $imageDirectory = public_path('assets/warranty-claim-images').'/';
        $width = 350; $height = 259;

        for ($i=0; $i < count($request->manufacturer_name) ; $i++) { 
            $component_name [] = [
              'manufacturer_name' => $request->manufacturer_name[$i],
              'model_number'  => $request->model_number[$i],
              'component_name'  => $request->component_name[$i],
                'quantity'  => $request->quantity[$i],
                'size' => $request->size[$i],
                'unit_of_measurement' => $request->unit_of_measurement[$i],
                'image' =>  $request->file('image')? $this->uploadImage($request->file('image')[$i]): 'UNAVAILABLE',
            ];
          }
    
  
     if(!$request->new_supplier_id){

        if($request->supplier_id)
        {

        $mail1 ="";   $valid=[];
        $supplier = $request->initial_supplier == $request->supplier_id? $request->initial_supplier: $request->supplier_id;
         
        $rfq = \App\Models\Rfq::create([
            'issued_by' => auth()->user()->id,
            'type' =>   'Warranty',
            'service_request_id'=> $request->service_request_id, 
        ]);


        // save each of the component name on the rfqbatch table
        foreach ($component_name as $key => $value) {
            \App\Models\RfqBatch::create([
          'rfq_id'           =>  $rfq->id,
          'component_name'    => $value['component_name']??'UNAVAILABLE',
          'model_number'      => $value['model_number']??'UNAVAILABLE',
          'quantity'          => $value['quantity']??'UNAVAILABLE',
          'amount'            => 0.00,
          'manufacturer_name' => $value['manufacturer_name']??'UNAVAILABLE',
          'size'              => $value['size']?? '0',
          'unit_of_measurement' => $value['unit_of_measurement']??'0',
           'image'              => $value['image']
        
          ]);
        }
        

     
        foreach ( $request->supplier_id as $supply) {
            $supplierDetails =  \App\Models\RfqSupplierInvoice::where(['rfq_id' => $request->rfq_id, 'supplier_id'=>$supply])->first();
            $ifSupplier =    \App\Models\RfqDispatchNotification::where([
                'rfq_id' => $request->rfq_id,  'supplier_id' => $supply])->first();

            if(!$ifSupplier){


            $creatteSupplierRfqDispatch = \App\Models\RfqDispatchNotification::create([
                    'rfq_id' => $request->rfq_id,
                    'supplier_id' => $supply,
                    'service_request_id' => $request->service_request_id,
                ]);

                if($creatteSupplierRfqDispatch){
                  $user =   \App\Models\User::where('id', $supply)->with('account', 'roles')->first();
                    $mail_data_supplier = collect([
                        'email' =>   $user->email,
                        'template_feature' => 'CSE_SENT_SUPPLIER_MESSAGE_NOTIFICATION',
                        'firstname' => $user->account->first_name.' '.$user->account->last_name,
                        'job_ref' =>  $request->service_request_unique_id,
                        'subject' => 'testing'
                    ]);
                    $mail1 = $this->mailAction($mail_data_supplier);
                 
                    }
            }
 
          }
          return  $mail1;
         }
         return false;
        }

       
         $users = \App\Models\Supplier::where('user_id' ,'<>', $request->initial_supplier)->with('user')->get();

         $updateOldSupplierRfqDispatch = \App\Models\RfqDispatchNotification::create([
            'rfq_id' => $request->rfq_id,
            'service_request_id' => $request->service_request_id,
            'supplier_id' => 0
        ]);


        $rfq = \App\Models\Rfq::create([
            'issued_by' => auth()->user()->id,
            'type' =>   'Warranty',
            'service_request_id'=> $request->service_request_id, 
        ]);


        // save each of the component name on the rfqbatch table
        foreach ($component_name as $key => $value) {
          $createRfqBatch =  \App\Models\RfqBatch::create([
          'rfq_id'           =>  $rfq->id,
          'component_name'    => $value['component_name']??'UNAVAILABLE',
          'model_number'      => $value['model_number']??'UNAVAILABLE',
          'quantity'          => $value['quantity']??'0',
          'amount'            => 0.00,
          'manufacturer_name' => $value['manufacturer_name']??'UNAVAILABLE',
          'size'              => $value['size']?? '0',
          'unit_of_measurement' => $value['unit_of_measurement']??'0',
           'image'              => $value['image']
        
          ]);
        }

       if( $updateOldSupplierRfqDispatch AND $createRfqBatch){
        foreach($users as $supplier){
            $mail_data_supplier = collect([
                'email' =>  $supplier['user']['email'],
                'template_feature' => 'CSE_SENT_SUPPLIER_MESSAGE_NOTIFICATION',
                'firstname' => $supplier['user']['account']['first_name'],
                'lastname' => $supplier['user']['account']['last_name'],
                'job_ref' =>  $request->service_request_unique_id,
                'subject' => 'testing'
            ]);
                $mail1 = $this->mailAction($mail_data_supplier);
                
            }  
        } 
        return '1';
     
    }
    
    protected function saveTechnician($serviceRequest, $service_request_warranty_id,$request ){
        $updateWarranty= '';
        $checkOldTechnician = \App\Models\ServiceRequestAssigned::where(['service_request_id'=>  $request->serviceRequestId, 'user_id'=> $request['technician_user_uuid']])->first();

        if($serviceRequest){
            $updateWarranty = \App\Models\ServiceRequestWarrantyIssued::where('service_request_warranty_id', $service_request_warranty_id)->update([
                    'service_request_warranty_id'     =>   $request['service_request_warranty_id'],
                    'technician_id'     =>   $checkOldTechnician ? NULL : $request['technician_user_uuid'],
                ]);   
        }
       return $updateWarranty;
    }



}

