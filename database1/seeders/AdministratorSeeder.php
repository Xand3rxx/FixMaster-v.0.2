<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Administrator User
        $admin = new \App\Models\User;
        $admin->email = 'admin@fix-master.com';
        $admin->password = bcrypt('admin12345');
        $admin->save();

        $admin1 = new \App\Models\User;
        $admin1->email = 'david.akinsola@gmail.com';
        $admin1->password = bcrypt('admin12345');
        $admin1->save();

        $admin2 = new \App\Models\User;
        $admin2->email = 'obuchi.omotosho@gmail.com';
        $admin2->password = bcrypt('admin12345');
        $admin2->save();


        // Administrator Roles and Permissions
        $adminRole = \App\Models\Role::where('slug', 'admin-user')->first();
        $admin->roles()->attach($adminRole);
        $admin1->roles()->attach($adminRole);
        $admin2->roles()->attach($adminRole);

        $adminPermission = \App\Models\Permission::where('slug', 'view-administrators')->first();
        $admin->permissions()->attach($adminPermission);
        $admin1->permissions()->attach($adminPermission);
        $admin2->permissions()->attach($adminPermission);

        // Administrator User Type
        $adminType = new \App\Models\UserType();
        $adminType->user_id    = $admin->id;
        $adminType->role_id    = $adminRole->id;
        $adminType->url        = $adminRole->url;
        $adminType->save();

        $adminType = new \App\Models\UserType();
        $adminType->user_id    = $admin1->id;
        $adminType->role_id    = $adminRole->id;
        $adminType->url        = $adminRole->url;
        $adminType->save();

        $adminType = new \App\Models\UserType();
        $adminType->user_id    = $admin2->id;
        $adminType->role_id    = $adminRole->id;
        $adminType->url        = $adminRole->url;
        $adminType->save();

        // Administrator Account
        $adminAccount = \App\Models\Account::create([
            'user_id'       =>  $admin->id,
            'state_id'      =>  24,
            'lga_id'        =>  505,
            'first_name'    => "Charles",
            'middle_name'   => "",
            'last_name'     => "Famoriyo",
            'gender'        => 'male',
            'avatar'        => 'home-fix-logo-coloredd.png',
        ]);

        $adminAccount1 = \App\Models\Account::create([
            'user_id'       =>  $admin1->id,
            'state_id'      =>  24,
            'lga_id'        =>  514,
            'first_name'    => "David ",
            'middle_name'   => "",
            'last_name'     => "Akinsola",
            'gender'        => 'male',
            'avatar'        => 'home-fix-logo-coloredd.png',
        ]);

        $adminAccount2 = \App\Models\Account::create([
            'user_id'       =>  $admin2->id,
            'state_id'      =>  24,
            'lga_id'        =>  500,
            'first_name'    => "Obuchi",
            'middle_name'   => "",
            'last_name'     => "Omotosho",
            'gender'        => 'female',
            'avatar'        => 'home-fix-logo-coloredd.png',
        ]);

        // Tehnician details Table
        $adminTable = new \App\Models\Administrator();
        $adminTable->user_id = $admin->id;
        $adminTable->account_id = $adminAccount->id;
        $adminTable->save();

        $adminTable = new \App\Models\Administrator();
        $adminTable->user_id = $admin1->id;
        $adminTable->account_id = $adminAccount1->id;
        $adminTable->save();

        $adminTable = new \App\Models\Administrator();
        $adminTable->user_id = $admin2->id;
        $adminTable->account_id = $adminAccount2->id;
        $adminTable->save();

        // Administrator Phone record Account
        $adminPhone = \App\Models\Phone::create([
            'user_id' =>  $admin->id,
            'account_id'  => $adminAccount->id,
            'country_id'  => 156, //Nigeria
            'number'   => "07057384920"
        ]);

        $adminPhone = \App\Models\Phone::create([
            'user_id' =>  $admin1->id,
            'account_id'  => $adminAccount1->id,
            'country_id'  => 156, //Nigeria
            'number'   => "08053782391"
        ]);

        $adminPhone = \App\Models\Phone::create([
            'user_id' =>  $admin2->id,
            'account_id'  => $adminAccount2->id,
            'country_id'  => 156, //Nigeria
            'number'   => "08027438470"
        ]);
    }
}
