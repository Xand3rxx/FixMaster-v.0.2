<?php

namespace Database\Seeders;

use App\Models\Earning;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EarningsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Earning::truncate();

        $earnings = new Earning();
        $earnings->uuid = Str::uuid('uuid');
        $earnings->role_name = 'QA';
        $earnings->earnings = 0.05;
        $earnings->save();

        $earnings = new Earning();
        $earnings->uuid = Str::uuid('uuid');
        $earnings->role_name = 'Franchisee';
        $earnings->earnings = 0.05;
        $earnings->save();

        $earnings = new Earning();
        $earnings->uuid = Str::uuid('uuid');
        $earnings->role_name = 'CSE';
        $earnings->earnings = 0.05;
        $earnings->save();

    }
}
