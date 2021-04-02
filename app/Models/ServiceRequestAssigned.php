<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestAssigned extends Model
{
    protected $table = 'service_request_assigned';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'service_request_id', 'job_accepted', 'job_acceptance_time', 'job_diagnostic_date', 'job_declined_time', 'job_completed_date'
    ];

    /**
     * Get the authenticated user assigned to the request
     */
    public function service_request()
    {
        return $this->belongsTo(ServiceRequest::class);
    }

    /**
     * Get the service request assigned user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function users()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    // public function account()
    // {
    //     return $this->belongsTo(Account::class, 'service_request_id', 'user_id');
    // }


    // public function service_requests()
    // {
    //     return $this->belongsTo(ServiceRequest::class)->with('users', 'client');
    // }
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'service_request_id', 'user_id' );
    }


    public function service_requests(){
        return $this->belongsTo(ServiceRequest::class)->with('users', 'client');
    }

    public function request_status()
    {
        return $this->belongsTo(Status::class, 'user_id');
    }


    // public function client_requesting_service()
    // {
    //     return $this->belongsTo(Account::class, 'user_id');
    // }

    // public function tech_account()
    // {
    //     return $this->belongsTo(Account::class, 'user_id', 'service_id');
    // }
    
    public function client_requesting_service()
    {
        return $this->belongsTo(Account::class, 'user_id');
    }

    public function tech_account()
    {
        return $this->belongsTo(Account::class, 'user_id', 'service_id' );
    }
}



