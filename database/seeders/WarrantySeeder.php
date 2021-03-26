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
                'uuid'      =>  Str::uuid('uuid'),      
                'user_id'   =>  1,
                'unique_id' =>  'WAR-09328932',
                'name'      =>  'Free Warranty',
                'amount'    =>  NULL,
                'warranty_type' => 'free',
                'description' =>  'This a free Warranty with maximum duration of one week after exectuion.'
            ),
            array(
                'uuid'      =>  Str::uuid('uuid'),      
                'user_id'   =>  1,
                'unique_id' =>  'WAR-86935247',
                'name'      =>  'Bronze Warranty',
                'amount'    =>  1000,
                'warranty_type' => 'extended',
                'description' =>  'This an extended Warranty with maximum duration of one(1) month after exectuion.',
            ),
            array(
                'uuid'      =>  Str::uuid('uuid'),      
                'user_id'   =>  1,
                'unique_id' =>  'WAR-8693524',
                'name'      =>  'Silver Warranty',
                'amount'    =>  2000,
                'warranty_type' => 'extended',
                'description' =>  'This an extended Warranty with maximum duration of six(6) months after exectuion.',
            ),
            array(
                'uuid'      =>  Str::uuid('uuid'),      
                'user_id'   =>  1,
                'unique_id' =>  'WAR-24006260',
                'name'      =>  'Gold Warranty',
                'amount'    =>  3500,
                'warranty_type' => 'extended',
                'description' =>  'This an extended Warranty with maximum duration of one(1) year after exectuion.',
            ),
        );

        DB::table('warranties')->insert($warranties);
    }
}
