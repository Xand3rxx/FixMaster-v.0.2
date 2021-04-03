<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'ratee_id','role_name', 'service_id','service_request_id','star', 'service_diagnosis_by'];


    public function services(){
        return $this->hasMany(Service::class, 'id', 'service_id');
}

public function service_request(){
    return $this->hasOne(ServiceRequest::class);
}

public function service(){
    return $this->hasOne(Service::class, 'id', 'service_id');
}


}
