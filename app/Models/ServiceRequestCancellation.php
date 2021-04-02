<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestCancellation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'service_request_id', 'reason'
    ];

}
