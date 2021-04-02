<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Str;

class WarrantySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('warranties')->delete();

        $warranties = array(

            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'unique_id'     =>  'WAR-09328932',
                'name'          =>  'Free Warranty',
                'percentage'    =>  0,
                'warranty_type' => 'free',
                'duration'      => 7,
                'description' =>  'This a free Warranty with maximum duration of one week after exectuion.'
            ),
            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'unique_id'     =>  'WAR-86935247',
                'name'          =>  'Bronze Warranty',
                'percentage'    =>  10,
                'warranty_type' => 'extended',
                'duration'      => 31,
                'description' =>  'This an extended Warranty with maximum duration of one(1) month after exectuion.',
            ),
            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'unique_id'     =>  'WAR-8693524',
                'name'          =>  'Silver Warranty',
                'percentage'    =>  20,
                'warranty_type' => 'extended',
                'duration'      => 186,
                'description' =>  'This an extended Warranty with maximum duration of six(6) months after exectuion.',
            ),
            array(
                'uuid'          =>  Str::uuid('uuid'),      
                'user_id'       =>  1,
                'unique_id'     =>  'WAR-24006260',
                'name'          =>  'Gold Warranty',
                'percentage'    =>  35,
                'warranty_type' => 'extended',
                'duration'      => 366,
                'description' =>  'This an extended Warranty with maximum duration of one(1) year after exectuion.',
            ),
        );

        DB::table('warranties')->insert($warranties);
    }
}
