<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
      'uuid', 'user_id', 'service_request_id', 'rfq_id', 'invoice_number', 'invoice_type', 'total_amount', 'amount_due', 'amount_paid', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function request()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id');
    }

    public function rfqs()
    {
        return $this->hasOne(Rfq::class, 'id', 'rfq_id');
    }

    public function serviceRequests()
    {
        return $this->hasOne(ServiceRequest::class, 'id', 'service_request_id');
    }
}
