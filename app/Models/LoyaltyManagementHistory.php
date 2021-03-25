<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class LoyaltyManagementHistory extends Model
{
    use HasFactory;

    protected $fillable = [
     
        'client_id','loyalty_id'
    
    ];

 

    protected $softDelete = true;

 


}
