<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rating;

class AdminRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rate = new Rating();
        $rate->user_id = 10;
        $rate->ratee_id = 2;
        $rate->save();

    }
}
