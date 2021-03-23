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

    // public function scopeServicies($query){
    //     return $query->select('*')
    //     ->orderBy('user_id', 'ASC');

    // }

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id')->withDefault();
    // }

    // public function users()
    // {
    //     return $this->hasMany(User::class, 'user_id')->withDefault();
    // }

    // public function service_requests()
    // {
    //     return $this->belongsTo(ServiceRequest::class, 'service_request_id');
    // }

    // public function request_status()
    // {
    //     return $this->belongsTo(Status::class, 'user_id');
    // }

    // public function client_requesting_service()
    // {
    //     return $this->belongsTo(Account::class, 'user_id');
    // }

}
