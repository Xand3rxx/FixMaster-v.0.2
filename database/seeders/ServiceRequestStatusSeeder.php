<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ServiceRequestStatus;

class ServiceRequestStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ServiceRequestStatus::create(
        [
            'id'            =>  1,
            'user_id'       =>  1,
            'name'          =>  'Pending',
            'deleted_at'    =>  NULL,
            'created_at'    =>  NULL,
            'updated_at'    =>  NULL
        ] );
                        
        ServiceRequestStatus::create(
        [
            'id'            =>  2,
            'user_id'       =>  1,
            'name'          =>  'Cancelled',
            'deleted_at'    =>  NULL,
            'created_at'    =>  NULL,
            'updated_at'    =>  NULL
        ] );
                        
        ServiceRequestStatus::create(
        [
            'id'            =>  3,
            'user_id'       =>  1,
            'name'          =>  'Completed',
            'deleted_at'    =>  NULL,
            'created_at'    =>  NULL,
            'updated_at'    =>  NULL
        ] );
                        
        ServiceRequestStatus::create(
        [
            'id'            =>  4,
            'user_id'       =>  1,
            'name'          =>  'Ongoing',
            'deleted_at'    =>  NULL,
            'created_at'    =>  NULL,
            'updated_at'    =>  NULL
        ] );
                        
        ServiceRequestStatus::create(
        [
            'id'            =>  5,
            'user_id'       =>  1,
            'name'          =>  'Enroute to Client\'s location',
            'deleted_at'    =>  NULL,
            'created_at'    =>  '2020-12-21 16:00:14',
            'updated_at'    =>  NULL
        ] );
                    
        ServiceRequestStatus::create(
        [
            'id'            =>  6,
            'user_id'       =>  1,
            'name'          =>  'Performing diagnosis',
            'deleted_at'    =>  NULL,
            'created_at'    =>  '2020-12-23 23:00:00',
            'updated_at'    =>  NULL
        ] );
    }
}
