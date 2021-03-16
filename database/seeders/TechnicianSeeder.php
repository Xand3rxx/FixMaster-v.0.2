<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TechnicianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Technician User
        $technician = new \App\Models\User;
        $technician->email = 'technician@fix-master.com';
        $technician->password = bcrypt('admin12345');
        $technician->save();

        $technician1 = new \App\Models\User;
        $technician1->email = 'andrew.nwankwo@gmail.com';
        $technician1->password = bcrypt('admin12345');
        $technician1->save();

        $technician2 = new \App\Models\User;
        $technician2->email = 'taofeek.adedokun@gmail.com';
        $technician2->password = bcrypt('admin12345');
        $technician2->save();

        // Technician Roles and Permissions
        $techniciainRole = \App\Models\Role::where('slug', 'technician-artisans')->first();
        $technician->roles()->attach($techniciainRole);

        $technicianPermission = \App\Models\Permission::where('slug', 'view-technicians')->first();
        $technician->permissions()->attach($technicianPermission);

        // Technician User Type
        $technicianType = new \App\Models\UserType();
        $technicianType->user_id    = $technician->id;
        $technicianType->role_id    = $techniciainRole->id;
        $technicianType->url        = $techniciainRole->url;
        $technicianType->save();

        $technicianType = new \App\Models\UserType();
        $technicianType->user_id    = $technician1->id;
        $technicianType->role_id    = $techniciainRole->id;
        $technicianType->url        = $techniciainRole->url;
        $technicianType->save();

        $technicianType = new \App\Models\UserType();
        $technicianType->user_id    = $technician2->id;
        $technicianType->role_id    = $techniciainRole->id;
        $technicianType->url        = $techniciainRole->url;
        $technicianType->save();

        // QA Account
        $technicianAccount = \App\Models\Account::create([
            'user_id'       =>  $technician->id,
            'first_name'    => "Jamal",
            'middle_name'   => "Sule",
            'last_name'     => "Diwa",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png',
        ]);

        $technicianAccount1 = \App\Models\Account::create([
            'user_id'       =>  $technician1->id,
            'first_name'    => "Andrew",
            'middle_name'   => "Nkem",
            'last_name'     => "Nwankwo",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png',
        ]);

        $technicianAccount2 = \App\Models\Account::create([
            'user_id'       =>  $technician2->id,
            'first_name'    => "Taofeek",
            'middle_name'   => "Idris",
            'last_name'     => "Adedokun",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png',
        ]);

        // Tehnician details Table
        $technicianTable = new \App\Models\Technician();
        $technicianTable->user_id = $technician->id;
        $technicianTable->account_id = $technicianAccount->id;
        $technicianTable->bank_id = 5;
        $technicianTable->save();

        $technicianTable = new \App\Models\Technician();
        $technicianTable->user_id = $technician1->id;
        $technicianTable->account_id = $technicianAccount1->id;
        $technicianTable->bank_id = 15;
        $technicianTable->save();

        $technicianTable = new \App\Models\Technician();
        $technicianTable->user_id = $technician2->id;
        $technicianTable->account_id = $technicianAccount2->id;
        $technicianTable->bank_id = 23;
        $technicianTable->save();

        // Technician Phone record Account
        $technicianPhone = \App\Models\Phone::create([
            'user_id' =>  $technician->id,
            'account_id'  => $technicianAccount->id,
            'country_id'  => 156, //Nigeria
            'number'   => "08132667823"
        ]);

        $technicianPhone = \App\Models\Phone::create([
            'user_id' =>  $technician1->id,
            'account_id'  => $technicianAccount1->id,
            'country_id'  => 156, //Nigeria
            'number'   => "08124363864"
        ]);

        $technicianPhone = \App\Models\Phone::create([
            'user_id' =>  $technician2->id,
            'account_id'  => $technicianAccount2->id,
            'country_id'  => 156, //Nigeria
            'number'   => "07004728329"
        ]);
    }
}
