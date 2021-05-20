<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestWarrantyReport extends Model
{
    // use HasFactory;

    protected $fillable = [
        'user_id', 'service_request_warranties_issued_id', 'report'
    ];
}