<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestAssigned extends Model
{
    use HasFactory;

    protected $table = 'service_request_assigned';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'service_request_id'];

    public function service_request(){
        return $this->belongsTo(ServiceRequest::class)->with('users', 'client');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
