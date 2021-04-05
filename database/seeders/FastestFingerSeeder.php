<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class FastestFingerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fastest_fingers')->delete();

        $fastestFingers = array(

            array(
                'user_id'               =>  16,
                'service_request_id'    =>  3, 
            ),
            array(
                'user_id'               =>  16,
                'service_request_id'    =>  4, 
            ),
        );

        DB::table('fastest_fingers')->insert($fastestFingers);
    }
}
