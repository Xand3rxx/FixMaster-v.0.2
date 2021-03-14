<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ServiceRequest extends Model
{
    use HasFactory, SoftDeletes;

//    // column name of key
//    protected $primaryKey = 'id';
//
//    // type of key
//    protected $keyType = 'string';
//
//    // whether the key is automatically incremented or not
//    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'user_id', 'admin_id', 'cse_id', 'technician_id', 'service_id', 'category_id', 'job_reference', 'security_code', 'service_request_status_id', 'total_amount',
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
            $serviceRequest->uuid = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function cse()
    {
        return $this->belongsTo(Cse::class);
    }

    public function cses()
    {
        return $this->belongsToMany(Cse::class);
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

}
