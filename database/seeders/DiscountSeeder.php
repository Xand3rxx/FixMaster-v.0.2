<?php

namespace Database\Seeders;

use App\Models\Discount;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $discount = new Discount();
        $discount->uuid = Str::uuid('uuid');
        $discount->name = 'Registration User Discount';
        $discount->entity = 'user';
        $discount->notify = '1';
        $discount->rate = 10;
        $discount->duration_start =  date('d-m-y');
        $discount->duration_end =  date('d-m-y');
        $discount->description =  'This is a discount which entitles all users to 5% off their complete registration.';
        $discount->parameter = NULL;
        $discount->created_by= 'dev@fix-master.com';
        $discount->status= 'activate';
        $discount->save();
    }
}
