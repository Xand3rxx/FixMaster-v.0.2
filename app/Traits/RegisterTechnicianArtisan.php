<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

trait RegisterTechnicianArtisan
{
    /**
     * Handle registration of an Administartor request for the application.
     *
     * @param  array $valid
     * @return bool 
     */
    public function register(array $valid, bool $registred = false)
    {
        DB::transaction(function () use ($valid, &$registred) {
            // Register the User
            $user = $this->createUser($valid);
            // find the Role of a Technicain
            $role = \App\Models\Role::where('slug', 'technician-artisans')->firstOrFail();
            // Attach the given role to the User
            $user->roles()->attach($role);
            // Attach the User Type for url path
            \App\Models\UserType::store($user->id, $role->id, $role->url);
            // Register the User Account
            $account = $user->account()->create([
                'state_id' => $valid['state_id'],
                'lga_id ' => $valid['lga_id '],
                'town_id ' => 2,

                'first_name' => $valid['first_name'],
                'middle_name' => $valid['middle_name'] ?: "",
                'last_name' => $valid['last_name'] ?: "",
                'gender' => $valid['gender'],

                'account_number' => $valid['account_number'],
                'avatar' => !empty($valid['avatar']) ? $valid['avatar']->store('avatar', 'public') : NULL,
            ]);
            // Register Address
            $user->addresses()->create([
                'account_id' => $account->id,
                'country_id' => 156,
                'name' => $valid['full_address']
            ]);
            

            dd($user, $valid);
        });
        return $registred;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function createUser(array $data)
    {
        return User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
