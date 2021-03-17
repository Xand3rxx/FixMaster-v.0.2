<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PriceHistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('price_histories')->delete();

        $priceHistories = array(

            array(
                'user_id'       =>  1,
                'price_id'      =>  1,
                'amount'        =>  2500,
                'created_at'    =>  '2021-01-01 6:28:38',
                'updated_at'    =>  NULL,
            ),
            array(
                'user_id'       =>  1,
                'price_id'      =>  2,
                'amount'        =>  3500,
                'created_at'    =>  '2021-01-01 6:28:38',
                'updated_at'    =>  NULL,
            ),
            array(
                'user_id'       =>  1,
                'price_id'      =>  3,
                'amount'        =>  4700,
                'created_at'    =>  '2021-01-01 6:28:38',
                'updated_at'    =>  NULL,
            ),
        );

        DB::table('price_histories')->insert($priceHistories);
    }
}
