<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $service1 = new Service();
        $service1->user_id = '1';
        $service1->category_id = '7';
        $service1->name = 'Bath-Tubs, Pipes, Kitchen Sink';
        // $service1->url = Str::uuid('uuid');
        $service1->description = 'We can fix all plumbing job types. Fix it right with an expert plumber. You Can Count On! All works are carried out promptly.';
        $service1->image = 'a99928b3-a89a-4596-9f09-92f03c410de2.jpg';
        $service1->save();

        $service2 = new Service();
        $service2->user_id = '1';
        $service2->category_id = '3';
        $service2->name = 'Computer & Laptops';
        // $service2->url = Str::uuid('uuid');
        $service2->description = 'With FixMaster you don\'t have to run to the repair shop every time your PC ends up with a fault, we have a host of tech support we provide. Maybe you need to upgrade your operating system, or install new software, protect against viruses. We do all that!';
        $service2->image = '19321f87-183c-4d74-8f7d-bdf5355307d3.jpg';
        $service2->save();

        $service3 = new Service();
        $service3->user_id = '1';
        $service3->category_id = '5';
        $service3->name = 'Dish & Washing Machine';
        // $service3->url = Str::uuid('uuid');
        $service3->description = 'If you\'ve got a leaky fridge, a rattling dryer, a barely cooling HVAC, a stove that no longer sizzles or a clogged dishwasher, we\'ve got you covered.';
        $service3->image = '47e66f4b-e329-40ff-a6ae-7e5b5683dab1.jpg';
        $service3->save();

        $service4 = new Service();
        $service4->user_id = '1';
        $service4->category_id = '7';
        $service4->name = 'Drainage, Shower, Soak-Away';
        $service4->url = Str::uuid('uuid');
        $service4->description = 'We can fix all plumbing job types. Fix it right with an expert plumber. You Can Count On! All works are carried out promptly.';
        $service4->image = '7cf740ad-902e-463d-9d9f-5fe3a73f5ae5.jpg';
        $service4->save();

    }
}
