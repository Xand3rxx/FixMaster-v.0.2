<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaymentDisbursed extends Model
{
    use HasFactory;

    //Table name
    protected $table = 'payments_disbursed';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'recipient_id', 'service_request_id', 'payment_mode_id', 'payment_reference', 'amount', 'payment_date', 'comment',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id'
    ];


    public function service_request(){
        return $this->hasOne(ServiceRequest::class, 'id', 'service_request_id');
    }

    public function mode(){
        return $this->hasOne(PaymentMode::class, 'id', 'payment_mode_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
