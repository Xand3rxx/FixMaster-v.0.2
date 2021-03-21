<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // supplier User
        $supplier = new \App\Models\User;
        $supplier->email = 'supplier@fix-master.com';
        $supplier->password = bcrypt('admin12345');
        $supplier->save();

        $supplier1 = new \App\Models\User;
        $supplier1->email = 'james.godfrey@gmail.com';
        $supplier1->password = bcrypt('admin12345');
        $supplier1->save();

        $supplier2 = new \App\Models\User;
        $supplier2->email = 'ezenwa.chinyere@gmail.com';
        $supplier2->password = bcrypt('admin12345');
        $supplier2->save();

        // supplier Roles and Permissions
        $supplierRole = \App\Models\Role::where('slug', 'supplier-user')->first();
        $supplier->roles()->attach($supplierRole);
        $supplier1->roles()->attach($supplierRole);
        $supplier2->roles()->attach($supplierRole);

        $supplierPermission = \App\Models\Permission::where('slug', 'view-suppliers')->first();
        $supplier->permissions()->attach($supplierPermission);
        $supplier1->permissions()->attach($supplierPermission);
        $supplier2->permissions()->attach($supplierPermission);

        // supplier User Type
        $supplierType = new \App\Models\UserType();
        $supplierType->user_id    = $supplier->id;
        $supplierType->role_id    = $supplierRole->id;
        $supplierType->url        = $supplierRole->url;
        $supplierType->save();

        $supplierType = new \App\Models\UserType();
        $supplierType->user_id    = $supplier1->id;
        $supplierType->role_id    = $supplierRole->id;
        $supplierType->url        = $supplierRole->url;
        $supplierType->save();

        $supplierType = new \App\Models\UserType();
        $supplierType->user_id    = $supplier2->id;
        $supplierType->role_id    = $supplierRole->id;
        $supplierType->url        = $supplierRole->url;
        $supplierType->save();

        // QA Account
        $supplierAccount = \App\Models\Account::create([
            'user_id'       =>  $supplier->id,
            'state_id'      =>  24,
            'lga_id'        =>  505,
            'first_name'    => "Henry",
            'middle_name'   => "Obaro",
            'last_name'     => "Efe",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png',
        ]);

        $supplierAccount1 = \App\Models\Account::create([
            'user_id'       =>  $supplier1->id,
            'state_id'      =>  24,
            'lga_id'        =>  514,
            'first_name'    => "James",
            'middle_name'   => "",
            'last_name'     => "Godfrey",
            'gender'        => 'male',
            'avatar'        => 'default-male-avatar.png',
        ]);

        $supplierAccount2 = \App\Models\Account::create([
            'user_id'       =>  $supplier2->id,
            'state_id'      =>  24,
            'lga_id'        =>  500,
            'first_name'    => "Chinenye",
            'middle_name'   => "Alexandria",
            'last_name'     => "Ezenwa",
            'gender'        => 'female',
            'avatar'        => 'default-female-avatar.png',
        ]);

        // Supplier details Table
        $supplierTable = new \App\Models\Supplier();
        $supplierTable->unique_id = 'SUP-F1A4E0D2'; 
        $supplierTable->user_id = $supplier->id;
        $supplierTable->account_id = $supplierAccount->id;
        $supplierTable->business_name = 'Search & Be Found';
        $supplierTable->years_of_business = '14';
        $supplierTable->education_level = 'university';
        $supplierTable->registered_identification_number = 'RN92BAD2A8'; 
        $supplierTable->business_description = 'Every company in the digital age wants one thing: to be found when their customer or prospect searches for them. They\'ve stated the benefit of using their agency in the title of their business. Work with Search & Be Found and ... be found by more customers.'; 
        $supplierTable->save();

        $supplierTable = new \App\Models\Supplier();
        $supplierTable->unique_id = 'SUP-1CBDD295'; 
        $supplierTable->user_id = $supplier1->id;
        $supplierTable->account_id = $supplierAccount1->id;
        $supplierTable->business_name = 'IMPACT';
        $supplierTable->years_of_business = '10';
        $supplierTable->education_level = 'polytechnic';
        $supplierTable->registered_identification_number = 'BNA9B41982';
        $supplierTable->business_description = 'IMPACT is an award-winning agency helping marketers and salespeople achieve their goals "and look like a rockstar in the process." Their business name reflects that mission and clearly states they exist to make you look good at work.'; 
        $supplierTable->save();

        $supplierTable = new \App\Models\Supplier();
        $supplierTable->unique_id = 'SUP-84E2F131'; 
        $supplierTable->user_id = $supplier2->id;
        $supplierTable->account_id = $supplierAccount2->id;
        $supplierTable->business_name = 'Delivius';
        $supplierTable->years_of_business = '5';
        $supplierTable->education_level = 'polytechnic';
        $supplierTable->registered_identification_number = 'BNE2E4B0E4'; 
        $supplierTable->business_description = 'Take a risk and keep testing, because what works today won\'t work tomorrow, but what worked yesterday may work again'; 
        $supplierTable->save();

        // supplier Phone record Account
        $supplierPhone = \App\Models\Phone::create([
            'user_id' =>  $supplier->id,
            'account_id'  => $supplierAccount->id,
            'country_id'  => 156, //Nigeria
            'number'   => "08168900129"
        ]);

        $supplierPhone = \App\Models\Phone::create([
            'user_id' =>  $supplier1->id,
            'account_id'  => $supplierAccount1->id,
            'country_id'  => 156, //Nigeria
            'number'   => "08134362177"
        ]);

        $supplierPhone = \App\Models\Phone::create([
            'user_id' =>  $supplier2->id,
            'account_id'  => $supplierAccount2->id,
            'country_id'  => 156, //Nigeria
            'number'   => "08016706323"
        ]);
    }
}
