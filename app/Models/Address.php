<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the address.
     */
    protected $fillable = [
        'user_id', 'account_id', 'country_id', 'address', 'address_longitude', 'address_latitude'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that owns the address.
     */
    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id')->withDefault();
    }
}
