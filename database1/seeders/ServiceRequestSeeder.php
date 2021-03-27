<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\ServiceRequest;
use DB;

class ServiceRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $serviceRequest = new ServiceRequest();
        // $serviceRequest->user_id = '2';
        // $serviceRequest->admin_id = '1';
        // $serviceRequest->cse_id = '2';
        // $serviceRequest->technician_id = '13';
        // $serviceRequest->service_id = '2';
        // $serviceRequest->job_reference = 'REF-66EB5A26';
        // $serviceRequest->security_code = 'SEC-27AEC73E';
        // $serviceRequest->service_request_status_id = '1';
        // $serviceRequest->total_amount = '4500';
        // $serviceRequest->save();

        // $serviceRequest = new ServiceRequest();
        // $serviceRequest->user_id = '2';
        // $serviceRequest->admin_id = '1';
        // $serviceRequest->cse_id = '2';
        // $serviceRequest->technician_id = '13';
        // $serviceRequest->service_id = '1';
        // $serviceRequest->job_reference = 'REF-330CB862';
        // $serviceRequest->security_code = 'SEC-88AC1B19';
        // $serviceRequest->service_request_status_id = '1';
        // $serviceRequest->total_amount = '2500';
        // $serviceRequest->save();

        // $serviceRequest = new ServiceRequest();
        // $serviceRequest->user_id = '2';
        // $serviceRequest->admin_id = '1';
        // $serviceRequest->cse_id = '3';
        // $serviceRequest->technician_id = '10';
        // $serviceRequest->service_id = '3';
        // $serviceRequest->job_reference = 'REF-27D2F0BE';
        // $serviceRequest->security_code = 'SEC-88AC1B19';
        // $serviceRequest->service_request_status_id = '1';
        // $serviceRequest->total_amount = '3500';
        // $serviceRequest->save();

        DB::table('service_requests')->delete();
        DB::table('service_request_cancellations')->delete();
        DB::table('service_request_assigned')->delete();

        //Admin ID's 22, 23, 24
        //Client ID's 5, 6, 7, 8, 9
        //CSE ID's 2, 3, 4
        //QA ID's 10, 11, 12
        //Technician ID's 13, 14, 15

        $serviceRequests = array(

            array(
                'uuid'                  => Str::uuid('uuid'),      
                'client_id'             => 5, 
                'service_id'            => 1, 
                'unique_id'             => 'REF-79A722D6', 
                'state_id'              => 24, 
                'lga_id'                => 498, 
                'town_id'               => 234, 
                'price_id'              => 1, 
                'phone_id'              => 1, 
                'address_id'            => 1, 
                'client_discount_id'    => NULL, 
                'client_security_code'  => 'SEC-02E65DEF',
                'status_id'             => 2, 
                'description'           => 'My PC no longer comes on even when plugged into a power source.', 
                'total_amount'          => 3500, 
                'preferred_time'        => NULL,
            ),
            array(
                'uuid'                  => Str::uuid('uuid'),      
                'client_id'             => 5, 
                'service_id'            => 13, 
                'unique_id'             => 'REF-66EB5A26', 
                'state_id'              => 24, 
                'lga_id'                => 500, 
                'town_id'               => 305, 
                'price_id'              => 2, 
                'phone_id'              => 1, 
                'address_id'            => 1, 
                'client_discount_id'    => NULL, 
                'client_security_code'  => 'SEC-27AEC73E', 
                'status_id'             => 2, 
                'description'           => 'Hello FixMaster, my dish washer pipe broke an hour ago, now water is spilling profusely, please send help quickly. Thanks', 
                'total_amount'          => 2500, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
            ),
            array(
                'uuid'                  => Str::uuid('uuid'),      
                'client_id'             => 5, 
                'service_id'            => 9, 
                'unique_id'             => 'REF-330CB862', 
                'state_id'              => 24, 
                'lga_id'                => 505, 
                'town_id'               => 415, 
                'price_id'              => 3, 
                'phone_id'              => 1, 
                'address_id'            => 1, 
                'client_discount_id'    => NULL, 
                'client_security_code'  => 'SEC-88AC1B19', 
                'status_id'             => 2, 
                'description'           => 'Washing machine plug is sparking. the cable appears melted. Thermocool washing machine.', 
                'total_amount'          => 4700, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
            ),
            array(
                'uuid'                  => Str::uuid('uuid'),      
                'client_id'             => 6, 
                'service_id'            => 1, 
                'unique_id'             => 'REF-27D2F0BE', 
                'state_id'              => 24, 
                'lga_id'                => 510, 
                'town_id'               => 500, 
                'price_id'              => 2, 
                'phone_id'              => 2, 
                'address_id'            => 2, 
                'client_discount_id'    => NULL, 
                'client_security_code'  => 'SEC-35FA9E28', 
                'status_id'             => 3, 
                'description'           => 'Please I urgently need a repair for my computer, It goes off saying overheating. I think the fan is faulty. You know it\'s New Year, so I\'ll need as swift response, thanks.', 
                'total_amount'          => 2500, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
            ),
            array(
                'uuid'                  => Str::uuid('uuid'),      
                'client_id'             => 6, 
                'service_id'            => 1, 
                'unique_id'             => 'REF-EEE7FD14', 
                'state_id'              => 24, 
                'lga_id'                => 510, 
                'town_id'               => 500, 
                'price_id'              => 2, 
                'phone_id'              => 2, 
                'address_id'            => 2, 
                'client_discount_id'    => NULL, 
                'client_security_code'  => 'SEC-92F0978A', 
                'status_id'             => 4, 
                'description'           => 'System crash error message displayed on screen.', 
                'total_amount'          => 6000, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
            ),
            array(
                'uuid'                  => Str::uuid('uuid'),      
                'client_id'             => 7, 
                'service_id'            => 8, 
                'unique_id'             => 'REF-1FC50FCC', 
                'state_id'              => 24, 
                'lga_id'                => 515, 
                'town_id'               => 600, 
                'price_id'              => 2, 
                'phone_id'              => 3, 
                'address_id'            => 3, 
                'client_discount_id'    => NULL, 
                'client_security_code'  => 'SEC-EBC1D654', 
                'status_id'             => 1, 
                'description'           => 'I cannot really explain what my dilemma is at the moment, just send someone over.', 
                'total_amount'          => 3500, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
            ),
            array(
                'uuid'                  => Str::uuid('uuid'),      
                'client_id'             => 8, 
                'service_id'            => 22, 
                'unique_id'             => 'REF-131D985E', 
                'state_id'              => 24, 
                'lga_id'                => 505, 
                'town_id'               => 600, 
                'price_id'              => 1, 
                'phone_id'              => 4, 
                'address_id'            => 4, 
                'client_discount_id'    => NULL, 
                'client_security_code'  => 'SEC-A62C515E', 
                'status_id'             => 1, 
                'description'           => 'My generator refuses to come on after several attempts.', 
                'total_amount'          => 2500, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
            ),

        );

        
        // $adminPhone = \App\Models\ServiceRequestAssigned::create([
        //     'user_id'               =>  '22',
        //     'service_request_id'    => '1',
        // ]);

        $serviceRequestCancelled = array(
            array(
                'user_id'               =>  6, 
                'service_request_id'    =>  4, 
                'reason'                =>  'Performed a hard restart and computer works fine now.',
            ),
        );

        $serviceRequestAssignee = array(
            array(
                'user_id'               => '22', 
                'service_request_id'    => '1', 
            ),
            array(
                'user_id'               => '2', 
                'service_request_id'    => '1', 
            ),
            array(
                'user_id'               => '10', 
                'service_request_id'    => '1', 
            ),
            array(
                'user_id'               => '13', 
                'service_request_id'    => '1', 
            ),

            array(
                'user_id'               => '22', 
                'service_request_id'    => '2', 
            ),
            array(
                'user_id'               => '2', 
                'service_request_id'    => '2', 
            ),
            array(
                'user_id'               => '10', 
                'service_request_id'    => '2', 
            ),
            array(
                'user_id'               => '13', 
                'service_request_id'    => '2', 
            ),

            array(
                'user_id'               => '22', 
                'service_request_id'    => '3', 
            ),
            array(
                'user_id'               => '2', 
                'service_request_id'    => '3', 
            ),
            array(
                'user_id'               => '10', 
                'service_request_id'    => '3', 
            ),
            array(
                'user_id'               => '13', 
                'service_request_id'    => '3', 
            ),

            array(
                'user_id'               => '22', 
                'service_request_id'    => '5', 
            ),
            array(
                'user_id'               => '2', 
                'service_request_id'    => '5', 
            ),
            array(
                'user_id'               => '10', 
                'service_request_id'    => '5', 
            ),
            array(
                'user_id'               => '13', 
                'service_request_id'    => '5', 
            ),


        );


        DB::table('service_requests')->insert($serviceRequests);
        DB::table('service_request_cancellations')->insert($serviceRequestCancelled);
        DB::table('service_request_assigned')->insert($serviceRequestAssignee);


    }
}
