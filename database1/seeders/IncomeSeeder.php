<?php

namespace Database\Seeders;

use App\Models\Income;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Income::truncate();

        $income = new Income();
        $income->uuid = Str::uuid('uuid');
        $income->income_name = 'FixMaster Royalty';
        $income->percentage = 0.10;
        $income->save();

        $income = new Income();
        $income->uuid = Str::uuid('uuid');
        $income->income_name = 'FixMaster Markup';
        $income->percentage = 0.10;
        $income->save();

        $income = new Income();
        $income->uuid = Str::uuid('uuid');
        $income->income_name = 'Logistics Cost';
        $income->amount = 3000;
        $income->save();

        $income = new Income();
        $income->uuid = Str::uuid('uuid');
        $income->income_name = 'Retention Fee';
        $income->percentage = 0.50;
        $income->save();
    }
}
