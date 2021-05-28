<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqSupplierInvoiceBatch extends Model
{
    use HasFactory;

    public $table = 'rfq_supplier_invoice_batches';

    public $timestamps = false;

    protected $fillable = [
        'rfq_supplier_invoice_id', 'rfq_batch_id', 'quantity', 'unit_price', 'total_amount',
    ];

    public function rfqBatch()
    {
        return $this->belongsTo(RfqBatch::class, 'rfq_batch_id');
    }

    //Scope to return all services
    public function scopeitemDeliveredSorting($query, array $filters)
    {
        // Split all filter parameters from the array of filters
        $query->when((array)$filters['supplier_id'] ?? null, function ($query, array $suppliers) {
            $query->whereIn('user_id', $suppliers[0]);
        })->when((string)$filters['job_status'] ?? null, function ($query) use ($filters) {
            $query->whereHas('service_request', function ($query) use ($filters) {
                $query->where('status_id', $filters['job_status']);
             });
        });
    }
}
