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
        DB::table('sub_statuses')->delete();
        DB::table('statuses')->delete();

        $status = array(

            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'name'          =>  'Pending',
                'ranking'       =>  1,
            ),
            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'name'          =>  'Ongoing',
                'ranking'       =>  2,
            ),
            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'name'          =>  'Cancelled',
                'ranking'       =>  3,
            ),
            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'name'          =>  'Completed',
                'ranking'       =>  4,
            ),

        );

        $subStatuses = array(
            array(
                'user_id'       =>  1,
                'status_id'     =>  1,
                'name'          =>  'Pending',
                'phase'         =>  1,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  1,
                'name'          =>  'FixMaster AI assigned a CSE',
                'phase'         =>  1,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  1,
                'name'          =>  'FixMaster AI assigned a Franchise as fallback',
                'phase'         =>  2,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Fanchisee assigned a CSE',
                'phase'         =>  1,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'FixMaster Admin assigned a QA',
                'phase'         =>  1,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Accepted the job and assigned a Technician',
                'phase'         =>  2,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Contacted Client for date and time availabilty',
                'phase'         =>  3,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'En-route to Client\'s address',
                'phase'         =>  4,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Arrived at Client\'s address',
                'phase'         =>  5,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Perfoming diagnosis',
                'phase'         =>  6,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Completed diagnosis and issued Final Invoice to Client',
                'phase'         =>  7,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Client accepted Final Invoice',
                'phase'         =>  8,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Client declined Final Invoice',
                'phase'         =>  9,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Awaiting Supplier\'s feedback on RFQ intiated as part of Final Invoice issued',
                'phase'         =>  10,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Supplier Delivery: Pending',
                'phase'         =>  11,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Supplier Delivery: Components are in transit',
                'phase'         =>  12,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Supplier has made delivery',
                'phase'         =>  12,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Work in progress',
                'phase'         =>  13,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Job completed for the day and it\'s to continue on a scheduled date',
                'phase'         =>  14,
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'status_id'     =>  2,
                'name'          =>  'Job is fully completed',
                'phase'         =>  15,
                'status'        =>  'active',
            ),

        );

        DB::table('statuses')->insert($status);
        DB::table('sub_statuses')->insert($subStatuses);
    }
}
