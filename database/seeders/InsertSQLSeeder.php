<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class InsertSQLSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = file_get_contents(database_path() . '/insert_sql/banks.sql');
        $paymentGateways = file_get_contents(database_path() . '/insert_sql/payment_gateways.sql');
    
        DB::statement($banks);
        DB::statement($paymentGateways);
    }
}
