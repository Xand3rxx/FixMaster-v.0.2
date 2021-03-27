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
    protected $fillable = ['user_id', 'account_id',  'referral_id', 'bank_id','firsttime', 'franchisee_id'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($cse) {
            $cse->unique_id = static::generate('cses', 'CSE-'); // Create a Unique cse id
        });
    }

    /**
     * Get the user that owns the Account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function serviceRequest()
    {
        return $this->hasOne(ServiceRequest::class);
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

}
