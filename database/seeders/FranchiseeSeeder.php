<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class FranchiseeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Franchisee User
        $franchisee = new \App\Models\User;
        $franchisee->email = 'franchisee@fix-master.com';
        $franchisee->password = bcrypt('admin12345');
        $franchisee->save();

        $franchisee1 = new \App\Models\User;
        $franchisee1->email = 'phillip.badmus@gmail.com';
        $franchisee1->password = bcrypt('admin12345');
        $franchisee1->save();

        $franchisee2 = new \App\Models\User;
        $franchisee2->email = 'juliet.ibe@gmail.com';
        $franchisee2->password = bcrypt('admin12345');
        $franchisee2->save();

        // Franchisee Roles and Permissions
        $franchiseeRole = \App\Models\Role::where('slug', 'franchisee-user')->first();
        $franchisee->roles()->attach($franchiseeRole);
        $franchisee1->roles()->attach($franchiseeRole);
        $franchisee2->roles()->attach($franchiseeRole);

        $franchiseePermission = \App\Models\Permission::where('slug', 'view-franchisee')->first();
        $franchisee->permissions()->attach($franchiseePermission);
        $franchisee1->permissions()->attach($franchiseePermission);
        $franchisee2->permissions()->attach($franchiseePermission);

        // Franchisee User Type
        $franchiseeType = new \App\Models\UserType();
        $franchiseeType->user_id    = $franchisee->id;
        $franchiseeType->role_id    = $franchiseeRole->id;
        $franchiseeType->url        = $franchiseeRole->url;
        $franchiseeType->save();

        $franchiseeType = new \App\Models\UserType();
        $franchiseeType->user_id    = $franchisee1->id;
        $franchiseeType->role_id    = $franchiseeRole->id;
        $franchiseeType->url        = $franchiseeRole->url;
        $franchiseeType->save();

        $franchiseeType = new \App\Models\UserType();
        $franchiseeType->user_id    = $franchisee2->id;
        $franchiseeType->role_id    = $franchiseeRole->id;
        $franchiseeType->url        = $franchiseeRole->url;
        $franchiseeType->save();

        // QA Account
        $franchiseeAccount = \App\Models\Account::create([
            'user_id'       =>  $franchisee->id,
            'state_id'      =>  24,
            'lga_id'        =>  505,
            'first_name'    => "Zion",
            'middle_name'   => "Emeka",
            'last_name'     => "Zuwa",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png',
        ]);

        $franchiseeAccount1 = \App\Models\Account::create([
            'user_id'       =>  $franchisee1->id,
            'state_id'      =>  24,
            'lga_id'        =>  514,
            'first_name'    => "Phillip",
            'middle_name'   => "Efetobore",
            'last_name'     => "Badmus",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png',
        ]);

        $franchiseeAccount2 = \App\Models\Account::create([
            'user_id'       =>  $franchisee2->id,
            'state_id'      =>  24,
            'lga_id'        =>  500,
            'first_name'    => "Juliet",
            'middle_name'   => "Chiamaka",
            'last_name'     => "Ibe",
            'gender'        => 'female',
            'avatar'        => 'default-female-avatar.png',
        ]);

        // Tehnician details Table
        $franchiseeTable = new \App\Models\Franchisee();
        $franchiseeTable->unique_id = 'FR-F85084D1'; 
        $franchiseeTable->cac_number = 'RN72632812'; 
        $franchiseeTable->user_id = $franchisee->id;
        $franchiseeTable->account_id = $franchiseeAccount->id;
        $franchiseeTable->franchise_description = 'This CSE Coordinator is in charge of Eti-Osa L.G.A of Lagos State.'; 
        $franchiseeTable->established_on = '2021-01-01';
        $franchiseeTable->save();

        $franchiseeTable = new \App\Models\Franchisee();
        $franchiseeTable->unique_id = 'FR-58C4D0E8'; 
        $franchiseeTable->cac_number = 'RN0932782';
        $franchiseeTable->user_id = $franchisee1->id;
        $franchiseeTable->account_id = $franchiseeAccount1->id;
        $franchiseeTable->franchise_description = 'This CSE Coordinator is in charge of Ojo L.G.A of Lagos State.'; 
        $franchiseeTable->established_on = '2021-01-01';
        $franchiseeTable->save();

        $franchiseeTable = new \App\Models\Franchisee();
        $franchiseeTable->unique_id = 'FR-E3708181'; 
        $franchiseeTable->cac_number = 'RN1234567'; 
        $franchiseeTable->user_id = $franchisee2->id;
        $franchiseeTable->account_id = $franchiseeAccount2->id;
        $franchiseeTable->franchise_description = 'This CSE Coordinator is in charge of Alimosho L.G.A of Lagos State.'; 
        $franchiseeTable->established_on = '2021-01-02';
        $franchiseeTable->save();

        // Franchisee Phone record Account
        $franchiseePhone = \App\Models\Phone::create([
            'user_id' =>  $franchisee->id,
            'account_id'  => $franchiseeAccount->id,
            'country_id'  => 156, //Nigeria
            'number'   => "08068236128"
        ]);

        $franchiseePhone = \App\Models\Phone::create([
            'user_id' =>  $franchisee1->id,
            'account_id'  => $franchiseeAccount1->id,
            'country_id'  => 156, //Nigeria
            'number'   => "08124367777"
        ]);

        $franchiseePhone = \App\Models\Phone::create([
            'user_id' =>  $franchisee2->id,
            'account_id'  => $franchiseeAccount2->id,
            'country_id'  => 156, //Nigeria
            'number'   => "07014728999"
        ]);

        $franchiseeAddress = \App\Models\Address::create([
            'user_id'           =>  $franchisee->id,
            'account_id'        =>  $franchiseeAccount->id,
            'country_id'        =>  156, //Nigeria
            'address'           =>  "6 Ikoyi Club 1938 Rd, Ikoyi, Lagos",
            'address_longitude' =>  "3.428400",
            'address_latitude'  =>  "6.452420",
        ]);

        $franchiseeAddress = \App\Models\Address::create([
            'user_id'           =>  $franchisee1->id,
            'account_id'        =>  $franchiseeAccount1->id,
            'country_id'        =>  156, //Nigeria
            'address'           =>  "Ipaja Rd, Alagba, Lagos",
            'address_longitude' =>  "3.303510",
            'address_latitude'  =>  "6.623930",
        ]);

        $franchiseeAddress = \App\Models\Address::create([
            'user_id'           =>  $franchisee2->id,
            'account_id'        =>  $franchiseeAccount2->id,
            'country_id'        =>  156, //Nigeria
            'address'           =>  "Akerele St, Surulere, Lagos",
            'address_longitude' =>  "3.358380",
            'address_latitude'  =>  "6.503340",
        ]);

    }
}
