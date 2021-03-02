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
            $user = $this->createUser($valid);
            $role = \App\Models\Role::where('id', $valid['role_id'])->first();
            $user->roles()->attach($role);
            \App\Models\UserType::store($user->id, $role->id, 'admin');
             $account = $user->account()->create([
                'first_name' => $valid['first_name'],
                'middle_name' => $valid['middle_name'] ?: "",
                'last_name' => $valid['last_name'] ?: "",
                'gender' => $valid['gender'] ?? 'others'
            ]);
            // $user->administrator
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
