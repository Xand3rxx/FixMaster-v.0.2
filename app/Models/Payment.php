<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'payment_channel',
        'payment_for',
        'unique_id',
        'reference_id',
        'status',
    ];

    public const PAYMENT_E_WALLET = 'e-wallet';
    public const PAYMENT_SERVICE_REQUEST = 'service-request';

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($payment) {
            $payment->user_id = auth()->user()->id; // Register the User making the payment transaction
        });
    }

    /**
     * Get the user that owns the Account.
     */
    public function user()
    {
        return $this->belongsTo(User::class)->with(['account', 'contact']);
    }

}
