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
            'En-route', 'Arrived', 'Diagnosing', 'Diagnosed', 'Issued RFQ', 'Awaiting supplier feedback', 'Delivery: Pending', 'Delivery: Shipped', 'Delivered', 'Job Completed'
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
