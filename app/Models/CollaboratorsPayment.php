<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CollaboratorsPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_request_id', 'payment_id', 'user_id', 'service_type', 'flat_rate', 'actual_labour_cost', 'actual_materials_cost', 'retention_fee', 'labour_markup_cost', 'material_markup_cost', 'royalty_fee', 'logistics_cost', 'tax_fee'
    ];
}
