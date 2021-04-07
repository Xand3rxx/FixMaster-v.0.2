<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqSupplierInvoice extends Model
{
    use HasFactory;


    protected $fillable = [
        'rfq_id', 'supplier_id', 'delivery_fee', 'delivery_time', 'total_amount',
    ];

    public function rfq()
    {
        return $this->belongsTo(Rfq::class);
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id')->with('account', 'supplier');
    }

    public function supplierInvoiceBatches()
    {
        return $this->belongsToMany(RfqSupplierInvoiceBatch::class);
    }

}
