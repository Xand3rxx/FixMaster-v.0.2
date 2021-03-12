<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

trait RegisterAdministrator
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
            // find the selected Role
            $role = \App\Models\Role::where('id', $valid['role_id'])->firstOrFail();
            // Attach the given role to the User
            $user->roles()->attach($role);
            // Attach the User Type for url path
            \App\Models\UserType::store($user->id, $role->id, 'admin');
            // Register the User Account
            $account = $user->account()->create([
                'first_name' => $valid['first_name'],
                'middle_name' => $valid['middle_name'] ?: "",
                'last_name' => $valid['last_name'] ?: "",
                'gender' => $valid['gender'] ?? 'others'
            ]);
            // Register the User Phone Number
            $user->phones()->create([
                'account_id' => $account->id,
                'country_id' => $account->id,
                'number' => $valid['phone_number'],
            ]);
            // Register the Administartor Account
            \App\Models\Administrator::create([
                'user_id' => $user->id,
                'account_id' => $account->id,
            ]);
            $registred = true;
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
