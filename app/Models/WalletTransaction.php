<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'user_id',
        'payment_id',
        'amount',
        'payment_type',
        'unique_id',
        'transaction_type',
        'opening_balance',
        'closing_balance',
        'status',
    ];
}
