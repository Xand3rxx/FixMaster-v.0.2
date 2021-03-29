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
        return $this->belongsTo(ServiceRequest::class)->with('users', 'client', 'status');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'service_request_id', 'user_id' );
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function service_requests(){
        return $this->belongsTo(ServiceRequest::class)->with('users', 'client');
    }

    public function request_status()
    {
        return $this->belongsTo(Status::class, 'user_id');
    }


    public function client_requesting_service()
    {
        return $this->belongsTo(Account::class, 'user_id');
    }

    public function tech_account()
    {
        return $this->belongsTo(Account::class, 'user_id', 'service_id' );
    }

    public function cse_service_request(){
        return $this->belongsTo(ServiceRequestAssigned::class)->with('users', 'client');
    }
}



