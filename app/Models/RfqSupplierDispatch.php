<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqSupplierDispatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'rfq_id', 'rfq_supplier_invoice', 'supplier_id', 'unique_id', 'courier_name', 'courier_phone_number', 'delivery_medium', 'cse_status', 'supplier_status', 'cse_comment', 'comment',
    ];

    public function rfq()
    {
        return $this->belongsTo(Rfq::class);
    }

    public function supplierInvoice()
    {
        return $this->belongsTo(RfqSupplierInvoice::class, 'rfq_supplier_invoice')->with('supplierInvoiceBatches');
    }
}
