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

        // AQ Roles and Permissions
        $qaRole = \App\Models\Role::where('slug', 'quality_assurance-user')->first();
        $qa->roles()->attach($qaRole);

        $qa_permission = \App\Models\Permission::where('slug', 'view-qa')->first();
        $qa->permissions()->attach($qa_permission);

        // QA User Type
        $qaType = new \App\Models\UserType();
        $qaType->user_id = $qa->id;
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

        // QA Account
        $qaAccount = \App\Models\Phone::create([
            'user_id' =>  $qa->id,
            'account_id'  => $qaAccount->id,
            'country_id'  => 156, //Nigeria
            'number'   => "09033319908"
        ]);

        // QA Table
        $qaTable = new \App\Models\QA();
        $qaTable->user_id = $qa->id;
        $qaTable->account_id = $qaAccount->id;
        // $qaTable->unique_id = 'QA-19807654';
        $qaTable->bank_id = 3;
        $qaTable->save();
    }
}
