<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = ['rater_id', 'ratee_id', 'service_request_id','star', 'updated_at', 'service_diagnosis_by'];


    public function services(){
        return $this->hasMany(Service::class, 'id', 'service_id');
}

    public function clientAccount(){
        return $this->hasOne(Account::class, 'user_id', 'rater_id');
    }

    public function cseAccount(){
        return $this->hasOne(Account::class, 'user_id', 'service_diagnosis_by');
    }


    public function client(){
        return $this->hasOne(Client::class, 'user_id', 'rater_id');
    }

public function service_request(){
    return $this->hasOne(ServiceRequest::class, 'id', 'service_request_id');
}

public function service(){
    return $this->hasOne(Service::class, 'id', 'service_id');
}


}
