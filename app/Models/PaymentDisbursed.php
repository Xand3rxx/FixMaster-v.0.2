<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaymentDisbursed extends Model
{
    use HasFactory;

    // column name of key
    protected $primaryKey = 'uuid';

    // type of key
    protected $keyType = 'string';

    // whether the key is automatically incremented or not
    public $incrementing = false;

    //Table name
    protected $table = 'payments_disbursed';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'user_id', 'recipient_id', 'service_request_id', 'payment_mode_id', 'payment_reference', 'amount', 'payment_date', 'comment',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new Payment Disbursed is to be created 
        static::creating(function ($serviceRequest) {
            $serviceRequest->uuid = (string) Str::uuid(); 
        });
    }
}
