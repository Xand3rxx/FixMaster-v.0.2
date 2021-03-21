<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class QASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // QA User
        $qa = new \App\Models\User;
        $qa->email = 'quality@fix-master.com';
        $qa->password = bcrypt('admin12345');
        $qa->save();

        $qa1 = new \App\Models\User;
        $qa1->email = 'desmond.john@yahoo.com';
        $qa1->password = bcrypt('admin12345');
        $qa1->save();

        $qa2 = new \App\Models\User;
        $qa2->email = 'bidemi.johson@outlook.co.uk';
        $qa2->password = bcrypt('admin12345');
        $qa2->save();

        // AQ Roles and Permissions
        $qaRole = \App\Models\Role::where('slug', 'quality-assurance-user')->first();
        $qa->roles()->attach($qaRole);
        $qa1->roles()->attach($qaRole);
        $qa2->roles()->attach($qaRole);

        $qa_permission = \App\Models\Permission::where('slug', 'view-qa')->first();
        $qa->permissions()->attach($qa_permission);
        $qa1->permissions()->attach($qa_permission);
        $qa2->permissions()->attach($qa_permission);

        // QA User Type
        $qaType = new \App\Models\UserType();
        $qaType->user_id = $qa->id;
        $qaType->role_id = $qaRole->id;
        $qaType->url = $qaRole->url;
        $qaType->save();

        $qaType = new \App\Models\UserType();
        $qaType->user_id = $qa1->id;
        $qaType->role_id = $qaRole->id;
        $qaType->url = $qaRole->url;
        $qaType->save();

        $qaType = new \App\Models\UserType();
        $qaType->user_id = $qa2->id;
        $qaType->role_id = $qaRole->id;
        $qaType->url = $qaRole->url;
        $qaType->save();

        // QA Account
        $qaAccount = \App\Models\Account::create([
            'user_id'       =>  $qa->id,
            'first_name'    => "Yvonne",
            'middle_name'   => "Obuchi",
            'last_name'     => "Okoye",
            'gender'        => 'female',
            'avatar'        => 'default-female-avatar.png',
        ]);

        $qaAccount1 = \App\Models\Account::create([
            'user_id'       =>  $qa1->id,
            'first_name'    => "Desmond",
            'middle_name'   => "",
            'last_name'     => "John",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png',
        ]);

        $qaAccount2 = \App\Models\Account::create([
            'user_id'       =>  $qa2->id,
            'first_name'    => "Bidemi",
            'middle_name'   => "Damian",
            'last_name'     => "Johnson",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png',
        ]);

        // QA Table
        $qaTable = new \App\Models\QA();
        $qaTable->user_id = $qa->id;
        $qaTable->account_id = $qaAccount->id;
        // $qaTable->unique_id = 'QA-19807654';
        $qaTable->bank_id = 3;
        $qaTable->save();

        $qaTable = new \App\Models\QA();
        $qaTable->user_id = $qa1->id;
        $qaTable->account_id = $qaAccount1->id;
        // $qaTable->unique_id = 'QA-19807654';
        $qaTable->bank_id = 7;
        $qaTable->save();

        $qaTable = new \App\Models\QA();
        $qaTable->user_id = $qa2->id;
        $qaTable->account_id = $qaAccount2->id;
        // $qaTable->unique_id = 'QA-19807654';
        $qaTable->bank_id = 5;
        $qaTable->save();

        // QA Phone Record 
        $qaPhone = \App\Models\Phone::create([
            'user_id' =>  $qa->id,
            'account_id'  => $qaAccount->id,
            'country_id'  => 156, //Nigeria
            'number'   => "09033319908"
        ]);

        $qaPhone = \App\Models\Phone::create([
            'user_id' =>  $qa1->id,
            'account_id'  => $qaAccount1->id,
            'country_id'  => 156, //Nigeria
            'number'   => "08030919912"
        ]);

        $qaPhone = \App\Models\Phone::create([
            'user_id' =>  $qa2->id,
            'account_id'  => $qaAccount2->id,
            'country_id'  => 156, //Nigeria
            'number'   => "08235610015"
        ]);
    }
}
