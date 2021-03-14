<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
        'payment_channel',
        'payment_for',
        'unique_id',
        'reference_id',
        'status',
    ];
}
