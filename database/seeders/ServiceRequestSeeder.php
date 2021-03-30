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
                'client_discount_id'    => 1, 
                'client_security_code'  => 'SEC-02E65DEF',
                'status_id'             => 2, 
                'description'           => 'My PC no longer comes on even when plugged into a power source.', 
                'total_amount'          => 1500, 
                'preferred_time'        => NULL,
                'created_at'            => '2020-12-14 13:39:55',
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
                'total_amount'          => 2000, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
                'created_at'            => '2020-12-15 10:51:29',
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
                'total_amount'          => 1000, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
                'created_at'            =>  '2021-01-05 15:04:48',
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
                'total_amount'          => 2000, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
                'created_at'            =>  '2021-01-14 15:53:45',
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
                'total_amount'          => 2000, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
                'created_at'            =>  '2021-01-05 18:53:37',
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
                'total_amount'          => 2000, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
                'created_at'            =>  '2021-01-05 18:53:37',
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
                'total_amount'          => 1500, 
                'preferred_time'        => \Carbon\Carbon::now('UTC'),
                'created_at'            =>  '2021-01-05 18:54:18',
            ),

        );

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
                'job_accepted'          =>  NULL, 
                'job_acceptance_time'   => NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL,
                'job_completed_date'    =>  NULL,
                'created_at'            => NULL, 
            ),
            array(
                'user_id'               => '2', 
                'service_request_id'    => '1',
                'job_accepted'          =>  'Yes', 
                'job_acceptance_time'   => '2020-12-14 15:08:52',
                'job_diagnostic_date'   =>  '2020-12-14 17:34:25',
                'job_declined_time'     =>  NULL,
                'job_completed_date'    =>  NULL,
                'created_at'            => '2020-12-14 13:43:14',
            ),
            array(
                'user_id'               => '10', 
                'service_request_id'    => '1',
                'job_accepted'          =>  NULL, 
                'job_acceptance_time'   => NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL,
                'job_completed_date'    =>  NULL,
                'created_at'            => NULL, 
            ),
            array(
                'user_id'               => '13', 
                'service_request_id'    => '1',
                'job_accepted'          =>  NULL, 
                'job_acceptance_time'   => NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL,
                'job_completed_date'    =>  NULL,
                'created_at'            => NULL, 
            ),

            array(
                'user_id'               => '22', 
                'service_request_id'    => '2',
                'job_accepted'          =>  NULL, 
                'job_acceptance_time'   => NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL,
                'job_completed_date'    =>  NULL,
                'created_at'            => NULL, 
            ),
            array(
                'user_id'               => '2', 
                'service_request_id'    => '2',
                'job_accepted'          =>  'Yes', 
                'job_acceptance_time'   => '2020-12-16 15:08:52',
                'job_diagnostic_date'   =>  '2020-12-16 15:56:17',
                'job_declined_time'     =>  NULL,
                'job_completed_date'    =>  NULL,
                'created_at'            => '2020-12-15 10:51:29',
            ),
            array(
                'user_id'               => '10', 
                'service_request_id'    => '2',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL, 
                'job_completed_date'    =>  NULL,
                'created_at'            => NULL, 
            ),
            array(
                'user_id'               => '13', 
                'service_request_id'    => '2',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL, 
                'job_completed_date'    =>  NULL,
                'created_at'            => NULL, 
            ),

            array(
                'user_id'               => '22', 
                'service_request_id'    => '3',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL, 
                'job_completed_date'    =>  NULL,
                'created_at'            => NULL, 
            ),
            array(
                'user_id'               => '2', 
                'service_request_id'    => '3',
                'job_accepted'          =>  'Yes', 
                'job_acceptance_time'   => '2020-01-07 10:11:52',
                'job_diagnostic_date'   =>  '2020-01-07 11:19:02',
                'job_declined_time'     =>  NULL,
                'job_completed_date'    =>  NULL,
                'created_at'            => '2021-01-05 15:04:48',
            ),
            array(
                'user_id'               => '10', 
                'service_request_id'    => '3',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL, 
                'job_completed_date'    =>  NULL,
                'created_at'            => NULL, 
            ),
            array(
                'user_id'               => '13', 
                'service_request_id'    => '3',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL, 
                'job_completed_date'    =>  NULL,
                'created_at'            => NULL, 
            ),

            array(
                'user_id'               => '22', 
                'service_request_id'    => '5',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL, 
                'job_completed_date'    =>  NULL,
                'created_at'            => NULL, 
            ),
            array(
                'user_id'               => '2', 
                'service_request_id'    => '5',
                'job_accepted'          =>  'Yes', 
                'job_acceptance_time'   => '2020-01-07 09:23:44',
                'job_diagnostic_date'   =>  '2020-01-07 12:26:09',
                'job_declined_time'     =>  NULL,
                'job_completed_date'    =>  '2020-01-08 10:34:45',
                'created_at'            => '2021-01-05 15:04:48',
            ),
            array(
                'user_id'               => '10', 
                'service_request_id'    => '5',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL,
                'job_completed_date'    =>  NULL, 
                'created_at'            => NULL, 
            ),
            array(
                'user_id'               => '13', 
                'service_request_id'    => '5',
                'job_acceptance_time'   => NULL,
                'job_accepted'          =>  NULL,
                'job_diagnostic_date'   =>  NULL,
                'job_declined_time'     =>  NULL, 
                'job_completed_date'    =>  NULL,
                'created_at'            => NULL, 
            ),


        );


        DB::table('service_requests')->insert($serviceRequests);
        DB::table('service_request_cancellations')->insert($serviceRequestCancelled);
        DB::table('service_request_assigned')->insert($serviceRequestAssignee);


    }
}
