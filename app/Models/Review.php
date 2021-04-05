<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'service_request_id','reviews', 'status'];

    public function service_request(){
        return $this->hasOne(ServiceRequest::class, 'id', 'service_request_id');
    }

    public function clientAccount(){
        return $this->hasOne(Account::class, 'user_id', 'client_id');
    }

}

