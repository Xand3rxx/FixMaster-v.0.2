<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id', 'user_id', 'account_id', 'business_name', 'years_of_business', 'education_level', 'registered_identification_number', 'business_description', 
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['unique_id','created_at', 'updated_at'];

    
}
