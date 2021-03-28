<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;


trait RegisterCSE
{
    use RegisterUser;
    protected $registred;

    /**
     * Handle registration of a CSE request for the application.
     *
     * @param  array $valid
     * @return bool 
     */
    public function register(array $valid)
    {
        return $this->attemptRegisteringCSE($valid);
    }

    /**
     * Handle registration of a CSE
     *
     * @param  array $valid
     * 
     * @throws Illuminate\Database\Eloquent\ModelNotFoundException
     * @return bool
     */
    protected function attemptRegisteringCSE(array $valid)
    {
        (bool) $registred = false;

        DB::transaction(function () use ($valid, &$registred) {
            // Register the User
            $user = $this->createUser($valid);
            // find client role using slug of client-user
            $role = \App\Models\Role::where('slug', 'cse-user')->firstOrFail();
            $user->roles()->attach($role);
            // Register CSE Permissions
            $cse_permission = \App\Models\Permission::where('slug', 'view-cse')->firstOrFail();
            $user->permissions()->attach($cse_permission);
            // CSE User Type
            \App\Models\UserType::store($user->id, $role->id, $role->url);
            // Register Town details
            $town =  \App\Models\Town::saveTown($valid['town']);
            // Register the User Account
            $account = $user->account()->create([
                'state_id'          => $valid['state_id'],
                'lga_id'            => $valid['lga_id'],
                'town_id'           => $town->id,
                'first_name'        => $valid['first_name'],
                'middle_name'       => $valid['middle_name'] ?: "",
                'last_name'         => $valid['last_name'],
                'gender'            => $valid['gender'],
                'bank_id'           => $valid['bank_id'],
                'account_number'    => $valid['account_number'],
                'avatar'            => !empty($valid['avatar']) ? $valid['avatar']->store('user-avatar') : $valid['gender'] = 'male' ? 'default-male-avatar.png' : 'default-female-avatar.png',
            ]);
            // Register the CSE Account
            $user->cse()->create([
                'account_id' => $account->id,
                'referral_id' => 2,
                'franchisee_id' => $valid['franchisee_id'],
            ]);
            // Register CSE Contact Details
            \App\Models\Contact::attemptToStore($user->id, $account->id, 156, $valid['phone_number'], $valid['full_address'], $valid['address_longitude'], $valid['address_latitude']);
            // update registered to be true
            $registred = true;
        });
        return $registred;
    }
}