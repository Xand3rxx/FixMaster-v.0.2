<?php

namespace Database\Seeders;

use App\Models\Cse;
use App\Models\UserType;
use Illuminate\Database\Seeder;

class CSESeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // CSE User
        $cse = new \App\Models\User;
        $cse->email = 'cse@fix-master.com';
        $cse->password = bcrypt('admin12345');
        $cse->save();

        $cse1 = new \App\Models\User;
        $cse1->email = 'grace.anjiola@gmail.com';
        $cse1->password = bcrypt('admin12345');
        $cse1->save();

        $cse2 = new \App\Models\User;
        $cse2->email = 'jackson.okoye@gmail.com';
        $cse2->password = bcrypt('admin12345');
        $cse2->save();

        // CSE Roles and Permissions
        $cseRole = \App\Models\Role::where('slug', 'cse-user')->first();
        $cse->roles()->attach($cseRole);

        $cse_permission = \App\Models\Permission::where('slug', 'view-cse')->first();
        $cse->permissions()->attach($cse_permission);

        // CSE User Type
        $cseType = new UserType();
        $cseType->user_id = $cse->id;
        $cseType->role_id = $cseRole->id;
        $cseType->url = $cseRole->url;
        $cseType->save();

        $cseType = new UserType();
        $cseType->user_id = $cse1->id;
        $cseType->role_id = $cseRole->id;
        $cseType->url = $cseRole->url;
        $cseType->save();

        $cseType = new UserType();
        $cseType->user_id = $cse2->id;
        $cseType->role_id = $cseRole->id;
        $cseType->url = $cseRole->url;
        $cseType->save();

        // CSE Account
        $cseAccount = \App\Models\Account::create([
            'user_id' =>  $cse->id,
            'first_name'    => "Benedict",
            'middle_name'   => "Mayowa",
            'last_name'     => "Olaoye",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png'
        ]);

        $cseAccount = \App\Models\Account::create([
            'user_id' =>  $cse->id,
            'first_name'    => "Benedict",
            'middle_name'   => "Mayowa",
            'last_name'     => "Olaoye",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png'
        ]);

        $cseAccount = \App\Models\Account::create([
            'user_id' =>  $cse->id,
            'first_name'    => "Benedict",
            'middle_name'   => "Mayowa",
            'last_name'     => "Olaoye",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png'
        ]);

        // CSE Table
        $cseTable = new Cse();
        $cseTable->user_id = $cse->id;
        $cseTable->account_id = $cseAccount->id;
        $cseTable->referral_id = '1';
        $cseTable->bank_id = '1';
        $cseTable->save();
    }   
}
