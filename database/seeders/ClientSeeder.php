<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Client User
        $client = new \App\Models\User;
        $client->email = 'client@fix-master.com';
        $client->password = bcrypt('admin12345');
        $client->save();

        // Client Roles and Permissions
        $clientRole = \App\Models\Role::where('slug', 'client-user')->first();
        $client->roles()->attach($clientRole);

        $client_permission = \App\Models\Permission::where('slug', 'view-clients')->first();
        $client->permissions()->attach($client_permission);

        // Client User Type
        $clientType = new \App\Models\UserType();
        $clientType->user_id = $client->id;
        $clientType->role_id = $clientRole->id;
        $clientType->url = $clientRole->url;
        $clientType->save();

        // Client Account
        $clientAccount = \App\Models\Account::create([
            'user_id'       =>  $client->id,
            'first_name'    => "Kelvin",
            'middle_name'   => "Israel",
            'last_name'     => "Adesanya",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png'
        ]);

        // Client Table
        $cseTable = new \App\Models\Client();
        $cseTable->user_id = $client->id;
        $cseTable->account_id = $clientAccount->id;
        $cseTable->estate_id = '1';
        $cseTable->	profession_id = '18';
        $cseTable->save();
    }
}
