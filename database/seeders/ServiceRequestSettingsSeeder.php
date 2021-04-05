<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\ServiceRequestSetting;

class ServiceRequestSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_request_settings')->delete();

        ServiceRequestSetting::create(
        [
            'radius'                =>  4,
            'max_ongoing_jobs'      =>  6,
        ]);
       
   }
}
