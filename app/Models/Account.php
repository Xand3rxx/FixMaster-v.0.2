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


}
