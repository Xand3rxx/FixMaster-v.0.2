<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstateDiscountHistory extends Model
{
    use HasFactory;


    protected $fillable = [
        'name', 'discount_id', 'estate_name', 'rate', 'notify', 'duration_start', 'duration_end','users','created_by'
    ];

    protected $softDelete = false;

}
