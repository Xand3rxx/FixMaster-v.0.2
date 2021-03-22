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
        $income->save();

        $income = new Income();
        $income->uuid = Str::uuid('uuid');
        $income->income_name = 'Initial Labour Cost';
        $income->save();

        $income = new Income();
        $income->uuid = Str::uuid('uuid');
        $income->income_name = 'Proceeding Labour Cost';
        $income->save();

        $income = new Income();
        $income->uuid = Str::uuid('uuid');
        $income->income_name = 'FixMaster Markup';
        $income->save();

        $income = new Income();
        $income->uuid = Str::uuid('uuid');
        $income->income_name = 'Logistics Cost';
        $income->save();
    }
}
