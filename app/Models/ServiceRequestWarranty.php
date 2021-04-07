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

    public function service_request(){
        return $this->hasOne(ServiceRequest::class, 'uuid', 'service_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class)->with(['account', 'contact']);
    }

    public function name()
    {
        return $this->hasOne(Account::class, 'user_id', 'client_id');
    }

    public function warranty_name()
    {
        return $this->hasOne(Warranty::class, 'id', 'warranty_id');
    }

    public function payment()
    {
        return $this->hasOne(ServiceRequest::class, 'id', 'service_request_id');
    }

    
}
