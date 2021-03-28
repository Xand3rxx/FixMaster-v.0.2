<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->delete();

        $ongoingSubStatuses = [
            'Phase1' => 'Assigned CSE', 
            'Phase2' => 'Assigned Technician', 
            'Phase3' => 'Contacted Client for availabilty',  
            'Phase4' => 'En-route to Client\'s address', 
            'Phase5' => 'Arrived', 
            'Phase6' => 'Perfoming diagnosis', 
            'Phase7' => 'Completed diagnosis', 
            'Phase8' => 'Issued RFQ', 
            'Phase9' =>  'Awaiting supplier\'s feedback', 
            'Phase10' => 'RFQ Delivery: Pending', 
            'Phase11' => 'RFQ Delivery: Shipped', 
            'Phase12' => 'RFQ Delivered', 
            'Phase13' => 'Job Completed'
        ];

        $status = array(

            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'name'          =>  'Pending',
                'sub_status'    =>  NULL,
                'ranking'       =>  1,
            ),
            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'name'          =>  'Ongoing',
                'sub_status'    =>  json_encode($ongoingSubStatuses),
                'ranking'       =>  2,
            ),
            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'name'          =>  'Cancelled',
                'sub_status'    =>  NULL,
                'ranking'       =>  3,
            ),
            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'name'          =>  'Completed',
                'sub_status'    =>  NULL,
                'ranking'       =>  4,
            ),

        );

        DB::table('statuses')->insert($status);
    }
}
