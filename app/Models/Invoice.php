<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
      'uuid', 'client_id', 'service_request_id', 'rfq_id', 'invoice_number', 'invoice_type', 'labour_cost', 'materials_cost', 'hours_spent', 'total_amount', 'amount_due', 'amount_paid', 'status'
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
        return $this->belongsTo(User::class);
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

    public function serviceRequest()
    {
        return $this->hasOne(ServiceRequest::class, 'id', 'service_request_id');
    }
}
