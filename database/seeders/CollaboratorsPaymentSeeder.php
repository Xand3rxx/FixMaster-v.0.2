<?php

namespace Database\Seeders;

use App\Models\CollaboratorsPayment;
use Illuminate\Database\Seeder;

class CollaboratorsPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CollaboratorsPayment::truncate();

        $collab_payment1 = new CollaboratorsPayment();
        $collab_payment1->service_request_id = 1;
        $collab_payment1->user_id = 2;
        $collab_payment1->service_type = 'Regular';
        $collab_payment1->flat_rate = 1000;
        $collab_payment1->save();
    }
}
