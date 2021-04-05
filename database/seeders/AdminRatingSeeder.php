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
        //cse rating
        $rate = new Rating();
        $rate->rater_id = 5;
        $rate->ratee_id = 2;
        $rate->star = 4;
        $rate->save();

        //service rating
        $rate1 = new Rating();
        $rate1->rater_id = 5;
        $rate1->service_request_id = 2;
        $rate1->star = 4;
        $rate1->save();

        //cse Diagnosis rating
        $rate2 = new Rating();
        $rate2->rater_id = 5;
        $rate2->service_request_id = 2;
        $rate2->star = 3;
        $rate2->service_diagnosis_by = 2;
        $rate2->save();

    }
}
