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
        // QA User
        $technician = new \App\Models\User;
        $technician->email = 'technician@fix-master.com';
        $technician->password = bcrypt('admin12345');
        $technician->save();

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

        // QA Account
        $technicianAccount = \App\Models\Account::create([
            'user_id'       =>  $technician->id,
            'first_name'    => "Jamal",
            'middle_name'   => "Sule",
            'last_name'     => "Diwa",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png',
        ]);

        // Tehnician details Table
        $technicianTable = new \App\Models\Technician();
        $technicianTable->user_id = $technician->id;
        $technicianTable->account_id = $technicianAccount->id;
        $technicianTable->bank_id = 2;
        $technicianTable->save();
    }
}
