<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestProgress extends Model
{
    use HasFactory;
    protected $table = 'service_request_progresses';

    protected $fillable = [
        'user_id', 'service_request_id', 'status_id', 'sub_status_id'
    ];
}
