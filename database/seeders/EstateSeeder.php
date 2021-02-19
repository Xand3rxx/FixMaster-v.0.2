<?php

namespace Database\Seeders;

use App\Models\Estate;
use Illuminate\Database\Seeder;

class EstateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $estate = new Estate();
        $estate->state_id = 25;
        $estate->lga_id = 362;
        $estate->first_name = 'Joe';
        $estate->last_name = 'Willock';
        $estate->email = 'joewill@gmail.com';
        $estate->phone_number = '08097782341';
        $estate->date_of_birth = date('d-m-y');
        $estate->identification_type = 'National ID';
        $estate->identification_number = '098293491093';
        $estate->expiry_date = date('d-m-y');
        $estate->full_address = 'Ikeja GRA';
        $estate->estate_name = 'Parkview Estate';
        $estate->town = 'Ikeja';
        $estate->is_active = '1';
        $estate->slug = 'parkview-estate';
        $estate->save();

        $estate = new Estate();
        $estate->state_id = 25;
        $estate->lga_id = 365;
        $estate->first_name = 'Tommy';
        $estate->last_name = 'Jones';
        $estate->email = 'tommy@yahoo.com';
        $estate->phone_number = '08073218234';
        $estate->date_of_birth = date('d-m-y');
        $estate->identification_type = 'National ID';
        $estate->identification_number = '982233110043';
        $estate->expiry_date = date('d-m-y');
        $estate->full_address = 'Lekki Phase 1 HE';
        $estate->estate_name = 'Beach Resort Estate';
        $estate->town = 'Lekki';
        $estate->is_active = '1';
        $estate->slug = 'beach-resort-estate';
        $estate->save();

        $estate = new Estate();
        $estate->state_id = 25;
        $estate->lga_id = 360;
        $estate->first_name = 'Frances';
        $estate->last_name = 'Henry';
        $estate->email = 'fhenry@gmail.com';
        $estate->phone_number = '09032193481';
        $estate->date_of_birth = date('d-m-y');
        $estate->identification_type = 'International Passport';
        $estate->identification_number = '4409321104';
        $estate->expiry_date = date('d-m-y');
        $estate->full_address = 'Agric, Ikorodu';
        $estate->estate_name = 'Gateway Estate';
        $estate->town = 'Ikorodu';
        $estate->is_active = '0';
        $estate->slug = 'gateway-estate';
        $estate->save();

    }
}
