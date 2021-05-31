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
use Image;


class WarrantClaimController extends Controller
{
    use findRecordWithUUID, Loggable, Utility;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function assignWarrantyTechnician(Request $request){
    //  dd($request);

        $this->validate(
            $request, 
           
            ['preferred_time' => 'required_if:service_request_warrant_issued_schedule_date,==,null'],
            ['required_if' => 'This scheduled fix date is required'],
         
        );
   

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
            return back()->with('error', 'An error occurred while trying to assigned new technician ');
        }
    

   
    }


    protected function save($serviceRequest, $service_request_warranty_id,$request ){

        if($request['technician_user_uuid'] || $request->preferred_time ){
           
       
        $upload='1'; $comment='1';
      
        if($serviceRequest){
            $updateWarranty = \App\Models\ServiceRequestWarrantyIssued::where('service_request_warranty_id', $service_request_warranty_id)->update([
                    'service_request_warranty_id'     =>   $request['service_request_warranty_id'],
                    'cse_id'             =>  Auth::id(),
                    'technician_id'     =>   $request['technician_user_uuid'],
                    'scheduled_datetime' => $request->preferred_time,
                    
                ]);
                $updateNewTechnician = \App\Models\ServiceRequestAssigned::where(['service_request_id'=>  $request->serviceRequestId, 'user_id'=> $request['technician_user_uuid']])->update([
                        'job_accepted'              => null,
                        'job_diagnostic_date'       => null,
                        'job_declined_time'         => null,
                        'job_completed_date'        => null,
                        'status'                    => null
                    ]);

        }else{
       
            $createWarranty = \App\Models\ServiceRequestWarrantyIssued::create([
                    'service_request_warranty_id'        =>   $request['service_request_warranty_id'],
                    'cse_id'             =>  Auth::id(),
                    'technician_id'     =>   $request['technician_user_uuid'],
                    'scheduled_datetime' => $request->preferred_time,
                  

                ]);
                \App\Models\ServiceRequestAssigned::create([
                    'user_id'                   => $request['technician_user_uuid'],
                    'service_request_id'        => $request->serviceRequestId,
                    'job_accepted'              => null,
                    'job_acceptance_time '      => null,
                    'job_diagnostic_date'       => null,
                    'job_declined_time'         => null,
                    'job_completed_date'        => null,
                    'status'                    => null
                ]);
        }
    }
        $serviceRequestIssued = $serviceRequest??  $createWarranty;

         //dd($serviceRequestIssued);
    

        if($request->hasFile('upload_image')) 
            $upload = $this->upload_image($request,$serviceRequestIssued);
        else
           $upload = '1';


        

        if($request->cse_comment || $request->causal_reason || $request->causal_agent_id) 
           $comment =  $this->diagnosticWarrantReport($request,$serviceRequestIssued);
        else
           $comment =  '1';

        if($request->intiate_rfq == 'yes')
            $done = $this->saveRfq($request);
        else
           $done = '1';    
        
      
        if($upload  AND $comment AND $done){
            return true;

        }else{
            return false; 
        }
        
    }

    protected function upload_image($request,$serviceRequesIssued){
        foreach ($request->file('upload_image') as $file) {
            $image = $file;
            $imageName = (string) Str::uuid() .'.'.$file->getClientOriginalExtension();
            $imageDirectory = public_path('assets/warranty-images').'/';
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
        $createWarranty = \App\Models\ServiceRequestWarrantyReport::create([
            'user_id'                                         =>  Auth::id(),
            'service_request_warranties_issued_id'             =>  $serviceRequesIssued->id,
            'report'                                           =>   $request->cse_comment,
            'causal_agent_id'                                  =>   $request->causal_agent_id,
            'causal_reason'                                    =>   $request->causal_reason,
            
        ]);

        return  $createWarranty ;
    }

    public function saveRfq($request){

        $updateOldSupplierStatus = \App\Models\RfqSupplierInvoice::where(['rfq_id'=> $request->rfq_id, 'accepted'=> 'Yes'])->update([
            'accepted'     =>   'Pending',
            
        ]);

      
        $updateNewSupplierStatus = \App\Models\RfqSupplierInvoice::where(['rfq_id'=> $request->rfq_id, 'supplier_id'=>$request->supplier_id])->update([
            'accepted'     =>   'Yes',
            
        ]);
         $supplierDetails =  \App\Models\RfqSupplierInvoice::where(['rfq_id'=> $request->rfq_id, 'supplier_id'=>$request->supplier_id])->first();
         $supplierRfq =  \App\Models\Rfq::where(['id'=> $request->rfq_id])->first();
         $suppliersUser  = \App\Models\Supplier::where(['id'=> $request->supplier_id])->with('user')->first();
        //  dd($suppliersUser->user->account->first_name, 'ref');

        $updateNewRfqSupplier = \App\Models\RfqSupplier::where(['rfq_id'=> $request->rfq_id])->update([
            'supplier_id'=> $request->supplier_id,
            'devlivery_fee' =>   $supplierDetails->delivery_fee,
            'delivery_time' => $supplierDetails->delivery_time?? now(),
            
        ]);
      

        $updateNewRfq = \App\Models\Rfq::where(['id'=> $request->rfq_id])->update([
            'issued_by'=> Auth::id(),
            'type' =>   'Warranty',
            'status' => 'Awaiting',
            'accepted' => 'Yes',
            'total_amount' => $supplierDetails->total_amount
            
        ]);

        $updateNewRfqSupplyDispatch = \App\Models\RfqSupplierDispatch::create([
            'rfq_id' => $request->rfq_id,
            'rfq_supplier_invoice' =>  $supplierDetails->id,
            'unique_id' => $supplierRfq->unique_id,
            'supplier_id' => $request->supplier_id,
            'courier_name' => 'Lasgdis',
            'courier_phone_number' => '080765432',
            'delivery_medium' => 'Okada',
            'cse_status' => $request->status == 'Approved'? 'Yes': 'No',
            'supplier_status' => 'Processing',
          
        ]);

         //$suppliersUser->user->email;
        // $mail_data = collect([
        //     'email' => 'woorad7@gmail.com',
        //     'template_feature' => 'CSE_SENT_SUPPLIER_MESSAGE_NOTIFICATION',
        //     'firstname' =>  $suppliersUser->user->account->first_name,
        //  ]);
      
       $mail = $this->mailAction($mail_data);
        return  $updateNewRfqSupplyDispatch;
    }


}

