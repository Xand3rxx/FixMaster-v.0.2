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
        
        $parameterArray = [
            'field' => '' , 
            'users' =>  '',
            'category' =>'' ,
            'services' => '',
            'estate' =>  ''
           ];

        $discount = new Discount();
        $discount->uuid = Str::uuid('uuid');
        $discount->name = 'Client Registration Discount';
        $discount->entity = 'client';
        $discount->notify = '1';
        $discount->rate = 10;
        $discount->duration_start =  date('d-m-y');
        $discount->duration_end =  date('d-m-y');
        $discount->description =  'This is a discount which entitles all users to 5% off their complete registration.';
        $discount->parameter = json_encode($parameterArray);
        $discount->created_by= 'dev@fix-master.com';
        $discount->status= 'activate';
        $discount->save();
    }
}
