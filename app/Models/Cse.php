<?php

namespace App\Models;

use App\Traits\GenerateUniqueIdentity as Generator;
use Illuminate\Database\Eloquent\Model;

class Cse extends Model
{
    use Generator;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'account_id',  'referral_id', 'bank_id', 'franchisee_id'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($cse) {
            $cse->unique_id = static::cse('cses', 'CSE-'); // Create a Unique cse id
            //    $cse->unique_id = 'CSE-'.strtoupper(substr(md5(time()), 0, 8));// Create a Unique CSE ID
        });
    }
}