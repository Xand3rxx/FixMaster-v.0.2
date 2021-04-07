<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqSupplierInvoiceBatch extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'rfq_supplier_invoice_id', 'rfq_batch_id', 'quantity', 'unit_price', 'total_amount',
    ];
}
