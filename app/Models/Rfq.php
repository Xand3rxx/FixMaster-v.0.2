<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rfq extends Model
{
    use HasFactory;

    protected $fillable = [
        'issued_by', 'client_id', 'invoice_id', 'service_request_id', 'batch_number', 'invoice_number', 'status', 'accepted', 'total_amount', 'created_at', 'updated_at'
    ];

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function invoices()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function serviceRequest()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id');
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class, 'service_request_id');
    }

    public function rfqBatch()
    {
        return $this->hasOne(RfqBatch::class, 'rfq_id');
    }

    public function rfqBatches()
    {
        return $this->hasMany(RfqBatch::class, 'rfq_id');
    }

    public function rfqSupplier()
    {
        return $this->hasOne(RfqSupplier::class, 'rfq_id');
    }

    public function rfqSupplies()
    {
        return $this->hasMany(RfqSupplier::class, 'rfq_id');
    }

    public function issuer()
    {
        return $this->belongsTo(User::class, 'issued_by')->with('account');
    }

    public function issuers()
    {
        return $this->hasMany(User::class, 'issued_by')->with('account');
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id')->with('account');
    }

    public function clients()
    {
        return $this->hasMany(User::class, 'client_id')->with('account');
    }

    
}
