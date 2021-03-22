<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'state_id',  'lga_id', 'town_id', 'first_name', 'middle_name', 'last_name', 'gender', 'account_number', 'avatar'];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    // protected $with = ['user'];

    /**
     * All of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['user'];

    /**
     * Get the user that owns the Account.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the phone associated with the user.
     */
    public function phone()
    {
        return $this->hasMany(Phone::class, 'user_id', 'user_id');
    }

    public function payment()
    {
        return $this->hasMany(PaymentDisbursed::class, 'user_id', 'user_id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'id');
    }

    public function lga()
    {
        return $this->belongsTo(Lga::class, 'id');
    }

    public function profession()
    {
        return $this->belongsTo(Profession::class, 'id');
    }

    public function client()
    {
        return $this->hasOne(client::class);
    }
    
    public function service_request()
    {
        return $this->hasMany(ServiceRequest::class, 'user_id', 'client_id');
    }
}
