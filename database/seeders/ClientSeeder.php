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

        $client1 = new \App\Models\User;
        $client1->email = 'wisdom.amana@gmail.com';
        $client1->password = bcrypt('admin12345');
        $client1->save();

        $client2 = new \App\Models\User;
        $client2->email = 'debo.williams@gmail.com';
        $client2->password = bcrypt('admin12345');
        $client2->save();

        $client3 = new \App\Models\User;
        $client3->email = 'jennifer.isaac@outlook.co.uk';
        $client3->password = bcrypt('admin12345');
        $client3->save();

        $client4 = new \App\Models\User;
        $client4->email = 'favour.chidera@yahoo.com';
        $client4->password = bcrypt('admin12345');
        $client4->save();

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

        $clientType = new \App\Models\UserType();
        $clientType->user_id = $client1->id;
        $clientType->role_id = $clientRole->id;
        $clientType->url = $clientRole->url;
        $clientType->save();

        $clientType = new \App\Models\UserType();
        $clientType->user_id = $client2->id;
        $clientType->role_id = $clientRole->id;
        $clientType->url = $clientRole->url;
        $clientType->save();

        $clientType = new \App\Models\UserType();
        $clientType->user_id = $client3->id;
        $clientType->role_id = $clientRole->id;
        $clientType->url = $clientRole->url;
        $clientType->save();

        $clientType = new \App\Models\UserType();
        $clientType->user_id = $client4->id;
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

        $clientAccount1 = \App\Models\Account::create([
            'user_id'       =>  $client1->id,
            'first_name'    => "Wisdom",
            'middle_name'   => "",
            'last_name'     => "Amana",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png'
        ]);

        $clientAccount2 = \App\Models\Account::create([
            'user_id'       =>  $client2->id,
            'first_name'    => "Adebola",
            'middle_name'   => "",
            'last_name'     => "Williams",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png'
        ]);

        $clientAccount3 = \App\Models\Account::create([
            'user_id'       =>  $client3->id,
            'first_name'    => "Jennifer",
            'middle_name'   => "",
            'last_name'     => "Isaac",
            'gender'        => 'male',
            'avatar'        => 'default-female-avatar.png'
        ]);

        $clientAccount4 = \App\Models\Account::create([
            'user_id'       =>  $client4->id,
            'first_name'    => "Favour",
            'middle_name'   => "Chidera",
            'last_name'     => "Onuoha",
            'gender'        => 'male',
            'avatar'        => 'default-female-avatar.png'
        ]);

        // Client Table
        $clientTable = new \App\Models\Client();
        $clientTable->user_id = $client->id;
        $clientTable->account_id = $clientAccount->id;
        $clientTable->estate_id = '1';
        $clientTable->	profession_id = '18';
        $clientTable->save();

        $clientTable = new \App\Models\Client();
        $clientTable->user_id = $client1->id;
        $clientTable->account_id = $clientAccount1->id;
        $clientTable->estate_id = '1';
        $clientTable->	profession_id = '12';
        $clientTable->save();

        $clientTable = new \App\Models\Client();
        $clientTable->user_id = $client2->id;
        $clientTable->account_id = $clientAccount2->id;
        $clientTable->estate_id = '2';
        $clientTable->	profession_id = '3';
        $clientTable->save();

        $clientTable = new \App\Models\Client();
        $clientTable->user_id = $client3->id;
        $clientTable->account_id = $clientAccount3->id;
        $clientTable->estate_id = '3';
        $clientTable->	profession_id = '14';
        $clientTable->save();

        $clientTable = new \App\Models\Client();
        $clientTable->user_id = $client4->id;
        $clientTable->account_id = $clientAccount4->id;
        $clientTable->estate_id = '3';
        $clientTable->	profession_id = '22';
        $clientTable->save();
    }
}
