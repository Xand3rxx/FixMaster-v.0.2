<?php

namespace App\Models;

use App\Traits\GenerateUniqueIdentity as Generator;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use Generator;

    /**
     * 
     * The attributes that aren't mass assignable.
     *
     * @var array
     *
     */
    protected $guarded = ['created_at', 'updated_at', 'firsttime','unique_id'];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($client) {
            $client->unique_id = static::generate('clients', 'WAL-'); // Create a Unique Client id
        });
    }

    /**
     * Get the user that owns the Account.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->with(['account', 'contact']);
    }

    

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    /**
     * Get the service request of the Client
     */
    public function service_request()
    {
        return $this->hasMany(ServiceRequest::class, 'client_id', 'user_id');
    }
    
}

