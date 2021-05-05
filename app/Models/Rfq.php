<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUniqueIdentity as Generator;

class Rfq extends Model
{
    use Generator;

    protected $fillable = [
        'uuid', 'unique_id', 'issued_by', 'client_id', 'invoice_id', 'service_request_id', 'invoice_number', 'status', 'accepted', 'total_amount', 'created_at', 'updated_at'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new Serivce Request is to be created
        static::creating(function ($rfq) {
            $rfq->uuid = (string) Str::uuid();
            $rfq->unique_id = static::generate('service_requests', 'RFQ-');
        });
    }

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


    /** 
     * Scope a query to only include all pending requests
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    //Scope to return all services  
    public function scopePendingQuotes($query)
    {
        return $query->select('*')
        ->where('status', 'Pending');
    }
    
}
