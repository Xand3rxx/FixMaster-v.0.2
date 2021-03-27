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
            'Phase 1' => 'Assigned CSE', 
            'Phase 2' => 'Assigned Technician', 
            'Phase 3' => 'Contacted Client for availabilty',  
            'Phase 4' => 'En-route to Client\'s address', 
            'Phase 5' => 'Arrived', 
            'Phase 6' => 'Perfoming diagnosis', 
            'Phase 7' => 'Completed diagnosis', 
            'Phase 8' => 'Issued RFQ', 
            'Phase 9' =>  'Awaiting supplier\'s feedback', 
            'Phase 10' => 'RFQ Delivery: Pending', 
            'Phase 11' => 'RFQ Delivery: Shipped', 
            'Phase 12' => 'RFQ Delivered', 
            'Phase 13' => 'Job Completed'
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
