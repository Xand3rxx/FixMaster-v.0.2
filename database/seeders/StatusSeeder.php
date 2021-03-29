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
            'Phase2' => 'Assigned QA', 
            'Phase3' => 'Assigned Technician', 
            'Phase4' => 'Contacted Client for availabilty',  
            'Phase5' => 'En-route to Client\'s address', 
            'Phase6' => 'Arrived', 
            'Phase7' => 'Perfoming diagnosis', 
            'Phase8' => 'Completed diagnosis', 
            'Phase9' => 'Issued RFQ', 
            'Phase10' =>  'Awaiting supplier\'s feedback', 
            'Phase11' => 'RFQ Delivery: Pending', 
            'Phase12' => 'RFQ Delivery: Shipped', 
            'Phase13' => 'RFQ Delivered', 
            'Phase14' => 'Job Completed'
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
