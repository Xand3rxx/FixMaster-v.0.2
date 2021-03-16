<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'account_id', 'user_id', 'country_id', 'address', 'address_longitude', 'address_latitude'
    ];
}
