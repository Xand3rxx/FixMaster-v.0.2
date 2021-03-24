<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\GenerateUniqueIdentity as Generator;

class ServiceRequest extends Model
{
    use HasFactory, SoftDeletes, Generator;

    // column name of key
    // protected $primaryKey = 'uuid';

    // type of key
    protected $keyType = 'string';

    // whether the key is automatically incremented or not
    public $incrementing = false;

    protected $fillable = [
        'client_id', 'service_id', 'unique_id', 'state_id', 'lga_id', 'town_id', 'price_id', 'phone_id', 'address_id', 'client_discount_id', 'client_security_code', 'status_id', 'description', 'total_amount', 'preferred_time'
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
        // Create a uuid when a new Serivce Request is to be created
        static::creating(function ($serviceRequest) {
            // Create a Unique Service Request uuid id
            $serviceRequest->uuid = (string) Str::uuid();

            // Create a Unique Service Request reference id
            $serviceRequest->unique_id = static::generate('service_requests', 'REF-');

            // Create a Unique Service Request Client Security Code id
            $serviceRequest->client_security_code = static::generate('service_requests', 'SEC-');

        });

    }

    public function user()
    {
        return $this->belongsTo(User::class)->with('account', 'roles');
    }

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
    
    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function clients()
    {
        return $this->belongsToMany(User::class);
    }

    public function cse()
    {
        return $this->belongsTo(Account::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'service_request_assigned')->with('account', 'roles');
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function service(){
        return $this->hasOne(Service::class, 'id', 'service_id');
    }

    public function services(){
            return $this->hasMany(Service::class, 'id', 'service_id');
    }

    public function rfq()
    {
        return $this->hasOne(Rfq::class, 'service_request_id');
    }

    public function rfqs()
    {
        return $this->hasMany(Rfq::class, 'service_request_id');
    }

    public function payment_disbursed(){
        return $this->belongsTo(PaymentDisbursed::class);
    }

    public function status(){
        return $this->hasOne(Status::class, 'id');
    }

    public function clientAccount()
    {
        return $this->belongsToMany(Account::class, 'user_id', 'client_id');
    }

}
