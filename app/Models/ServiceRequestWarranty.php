<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestWarranty extends Model
{
    use HasFactory;

    protected $fillable = [
        'created_by', 'warranty_id', 'service_request_id', 'start_date', 'expiration_date'
    ];
}
