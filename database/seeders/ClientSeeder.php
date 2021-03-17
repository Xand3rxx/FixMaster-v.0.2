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
        $client1->roles()->attach($clientRole);
        $client2->roles()->attach($clientRole);
        $client3->roles()->attach($clientRole);
        $client4->roles()->attach($clientRole);

        $client_permission = \App\Models\Permission::where('slug', 'view-clients')->first();
        $client->permissions()->attach($client_permission);
        $client1->permissions()->attach($client_permission);
        $client2->permissions()->attach($client_permission);
        $client3->permissions()->attach($client_permission);
        $client4->permissions()->attach($client_permission);

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
            'avatar'        => '0c9ac4cada39ba68e97fc6c0a0807458d1385048.jpg'
        ]);

        $clientAccount1 = \App\Models\Account::create([
            'user_id'       =>  $client1->id,
            'first_name'    => "Wisdom",
            'middle_name'   => "Basil",
            'last_name'     => "Amana",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png'
        ]);

        $clientAccount2 = \App\Models\Account::create([
            'user_id'       =>  $client2->id,
            'first_name'    => "Adebola",
            'middle_name'   => "Julius",
            'last_name'     => "Williams",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png'
        ]);

        $clientAccount3 = \App\Models\Account::create([
            'user_id'       =>  $client3->id,
            'first_name'    => "Jennifer",
            'middle_name'   => "Ifeyinwa",
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
        $clientTable->unique_id = 'WAL-23782382';
        $clientTable->account_id = $clientAccount->id;
        $clientTable->estate_id = '1';
        $clientTable->	profession_id = '18';
        $clientTable->save();

        $clientTable = new \App\Models\Client();
        $clientTable->user_id = $client1->id;
        $clientTable->unique_id = 'WAL-21780953';
        $clientTable->account_id = $clientAccount1->id;
        $clientTable->estate_id = '1';
        $clientTable->	profession_id = '12';
        $clientTable->save();

        $clientTable = new \App\Models\Client();
        $clientTable->user_id = $client2->id;
        $clientTable->unique_id = 'WAL-50B6D80A';
        $clientTable->account_id = $clientAccount2->id;
        $clientTable->estate_id = '2';
        $clientTable->	profession_id = '3';
        $clientTable->save();

        $clientTable = new \App\Models\Client();
        $clientTable->user_id = $client3->id;
        $clientTable->unique_id = 'WAL-BFE41F23';
        $clientTable->account_id = $clientAccount3->id;
        $clientTable->estate_id = '3';
        $clientTable->	profession_id = '14';
        $clientTable->save();

        $clientTable = new \App\Models\Client();
        $clientTable->user_id = $client4->id;
        $clientTable->unique_id = 'WAL-DB9DBC86';
        $clientTable->account_id = $clientAccount4->id;
        $clientTable->estate_id = '3';
        $clientTable->	profession_id = '22';
        $clientTable->save();

        $clientPhone = \App\Models\Phone::create([
            'user_id' =>  $client->id,
            'account_id'  => $clientAccount->id,
            'country_id'  => 156, //Nigeria
            'number'   => "07069836642"
        ]);

        $clientPhone = \App\Models\Phone::create([
            'user_id' =>  $client1->id,
            'account_id'  => $clientAccount1->id,
            'country_id'  => 156, //Nigeria
            'number'   => "08069386642"
        ]);

        $clientPhone = \App\Models\Phone::create([
            'user_id' =>  $client2->id,
            'account_id'  => $clientAccount2->id,
            'country_id'  => 156, //Nigeria
            'number'   => "08069386641"
        ]);

        $clientPhone = \App\Models\Phone::create([
            'user_id' =>  $client3->id,
            'account_id'  => $clientAccount2->id,
            'country_id'  => 156, //Nigeria
            'number'   => "07036722889"
        ]);

        $clientPhone = \App\Models\Phone::create([
            'user_id' =>  $client4->id,
            'account_id'  => $clientAccount2->id,
            'country_id'  => 156, //Nigeria
            'number'   => "09082354902"
        ]);

        $clientAddress = \App\Models\Address::create([
            'user_id'           =>  $client->id,
            'account_id'        =>  $clientAccount->id,
            'country_id'        =>  156, //Nigeria
            'address'           =>  "14 Idowu Martins St, Victoria Island, Lagos",
            'address_longitude' =>  "3.420010",
            'address_latitude'  =>  "6.432820",
        ]);

        $clientAddress = \App\Models\Address::create([
            'user_id'           =>  $client1->id,
            'account_id'        =>  $clientAccount1->id,
            'country_id'        =>  156, //Nigeria
            'address'           =>  "1-9 Reeve Rd, Ikoyi, Lagos",
            'address_longitude' =>  "3.441440",
            'address_latitude'  =>  "6.453120",
        ]);

        $clientAddress = \App\Models\Address::create([
            'user_id'           =>  $client2->id,
            'account_id'        =>  $clientAccount2->id,
            'country_id'        =>  156, //Nigeria
            'address'           =>  "Bisola Durosinmi Etti Drive, The Rock Dr, Lekki Phase 1, Lagos",
            'address_longitude' =>  "3.464150",
            'address_latitude'  =>  "6.437240",
        ]);

        $clientAddress = \App\Models\Address::create([
            'user_id'           =>  $client3->id,
            'account_id'        =>  $clientAccount3->id,
            'country_id'        =>  156, //Nigeria
            'address'           =>  "8 Oba Akinjobi Way, Ikeja GRA, Ikeja",
            'address_longitude' =>  "3.346660",
            'address_latitude'  =>  "6.586420",
        ]);

        $clientAddress = \App\Models\Address::create([
            'user_id'           =>  $client4->id,
            'account_id'        =>  $clientAccount4->id,
            'country_id'        =>  156, //Nigeria
            'address'           =>  "8 Oremeji St, Oke Odo, Lagos",
            'address_longitude' =>  "3.346660",
            'address_latitude'  =>  "6.586420",
        ]);
    }
}

