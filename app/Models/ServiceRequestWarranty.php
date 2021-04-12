<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestWarranty extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'warranty_id', 'service_request_id', 'start_date', 'expiration_date', 'amount', 'status', 'initiated', 'has_been_attended_to', 'reason',
    ];

    public function service_request(){
        return $this->hasOne(ServiceRequest::class, 'id', 'service_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id', 'id')->with(['account']);
    }

    public function name()
    {
        return $this->hasOne(Account::class, 'user_id', 'client_id');
    }

    public function warranty()
    {
        return $this->hasOne(Warranty::class, 'id', 'warranty_id');
    }

    public function payment()
    {
        return $this->hasOne(ServiceRequest::class, 'id', 'service_request_id');
    }

    
}
