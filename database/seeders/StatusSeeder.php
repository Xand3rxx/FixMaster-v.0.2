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
                'uuid'          =>  '8e4521a1-3329-4a76-b2fd-a674683002e3',
                'status_id'     =>  1,
                'name'          =>  'Pending',
                'phase'         =>  1,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '3f8d1494-a53b-4671-8447-10d3ca92b270',
                'status_id'     =>  1,
                'name'          =>  'FixMaster AI assigned a CSE',
                'phase'         =>  2,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '15f402e8-cb1c-48aa-ac0b-727a24d14c3d',
                'status_id'     =>  1,
                'name'          =>  'FixMaster AI assigned a Franchise as fallback',
                'phase'         =>  3,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'dd415ab5-437a-46d5-93b1-84fbd4d67edf',
                'status_id'     =>  1,
                'name'          =>  'Fanchisee assigned a CSE',
                'phase'         =>  4,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'cee7aa41-2818-497b-98e2-b850a100741a',
                'status_id'     =>  1,
                'name'          =>  'FixMaster Admin assigned a QA',
                'phase'         =>  5,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '7337bdd3-2ed9-4a2b-a5bb-b526d86f039b',
                'status_id'     =>  2,
                'name'          =>  'Assigned a Technician',
                'phase'         =>  1,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'd258667a-1953-4c66-b746-d0c40de7189d',
                'status_id'     =>  2,
                'name'          =>  'Contacted Client for date and time availability',
                'phase'         =>  2,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'eb51cdd5-3c3a-48c9-b011-cc3fd2bc3e25',
                'status_id'     =>  2,
                'name'          =>  'En-route to Client\'s address',
                'phase'         =>  3,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '4909568f-389c-42de-9d13-91453c495813',
                'status_id'     =>  2,
                'name'          =>  'Arrived at Client\'s address',
                'phase'         =>  4,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'b8abbe05-209f-4eeb-8cdb-cef0a354f160',
                'status_id'     =>  2,
                'name'          =>  'Perfoming diagnosis',
                'phase'         =>  5,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'f95c31c6-6667-4a64-bee3-8aa4b5b943d3',
                'status_id'     =>  2,
                'name'          =>  'Completed diagnosis',
                'phase'         =>  6,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '17e3ce54-2089-4ff7-a2c1-7fea407df479',
                'status_id'     =>  2,
                'name'          =>  'Client accepted Diagnosis Invoice',
                'phase'         =>  7,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '',
                'status_id'     =>  2,
                'name'          =>  'Client declined Diagnosis Invoice',
                'phase'         =>  8,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '2c818bc3-3f19-4574-99e7-e4f0db0bca2d',
                'status_id'     =>  2,
                'name'          =>  'Issued Final Invoice to Client',
                'phase'         =>  9,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'b82ea1c6-fc12-46ec-8138-a3ed7626e0a4',
                'status_id'     =>  2,
                'name'          =>  'Client accepted Final Invoice',
                'phase'         =>  10,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '8936191d-03ad-4bfa-9c71-e412ee984497',
                'status_id'     =>  2,
                'name'          =>  'Client declined Final Invoice',
                'phase'         =>  11,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '2df4da1e-6c07-402c-a316-0378d37e50a1',
                'status_id'     =>  2,
                'name'          =>  'Issued a new RFQ',
                'phase'         =>  12,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '70583091-9f95-4f3a-9d57-655e55d471e8',
                'status_id'     =>  2,
                'name'          =>  'Awaiting Supplier\'s feedback on RFQ intiated as part of Final Invoice issued',
                'phase'         =>  13,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'ef8c69e8-5634-4bd0-a7e6-b73a89ae034f',
                'status_id'     =>  2,
                'name'          =>  'Supplier Delivery: Pending',
                'phase'         =>  14,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '6e266cf8-7eeb-49be-86ad-375c7c7416fa',
                'status_id'     =>  2,
                'name'          =>  'Supplier Delivery: Components are in transit',
                'phase'         =>  15,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'bd2ab8b8-9f0b-4b8e-afa9-130c837ecbd1',
                'status_id'     =>  2,
                'name'          =>  'Supplier has made delivery',
                'phase'         =>  16,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'e52afda2-8605-4ec9-9682-c11008a434d1',
                'status_id'     =>  2,
                'name'          =>  'Work in progress',
                'phase'         =>  17,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  'c6a7481a-182b-410b-adae-0451f3da260b',
                'status_id'     =>  2,
                'name'          =>  'Job completed for the day and it\'s to continue on a scheduled date',
                'phase'         =>  18,
                'recurrence'    =>  'Yes',
                'status'        =>  'active',
            ),
            array(
                'user_id'       =>  1,
                'uuid'          =>  '0b8b6887-7cff-4eca-9cb1-5a5db693332d',
                'status_id'     =>  2,
                'name'          =>  'Job is fully completed',
                'phase'         =>  19,
                'recurrence'    =>  'No',
                'status'        =>  'active',
            ),

        );

        DB::table('statuses')->insert($status);
        DB::table('sub_statuses')->insert($subStatuses);
    }
}
