<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

trait RegisterClient
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
            // store in users Table
            $user = $this->createUser($valid);

            // find client role using slug of client-user
            $role = \App\Models\Role::where('slug', 'client-user')->first();

            // Attach to User
            $user->roles()->attach($role);

            // store User Type
            \App\Models\UserType::store($user->id, $role->id, $role->url);

            // store in accounts table
            $account = $user->account()->create([
                'state_id'          =>  $valid['state_id'],
                'lga_id'          =>  $valid['lga_id'],
                'town_id'          =>  $valid['town_id'] ?? '0',
                'first_name'        => $valid['first_name'],
                'middle_name'       => $valid['middle_name'] ?: "",
                'last_name'         => $valid['last_name'],
                'gender'            => $valid['gender'],
            ]);

            // Store in clients table
            \App\Models\Client::create([
                'user_id' => $user->id,
                'account_id' => $account->id,
                'estate_id' => $valid['estate_id'] ?? "0",
                'profession_id' => $valid['profession_id'] ?? "0",
            ]);

            // update registered to be true
            $registred = true;
            $this->guard()->login($user);
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

    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }
}
