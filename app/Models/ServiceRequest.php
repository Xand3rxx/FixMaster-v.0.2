<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\GenerateUniqueIdentity as Generator;

class ServiceRequest extends Model
{
    use SoftDeletes, Generator;

    const SERVICE_REQUEST_STATUSES = [
        'Pending'   => 1,
        'Ongoing'   => 2,
        'Canceled' => 3,
        'Completed' => 4
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['uuid', 'client_security_code', 'deleted_at', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'sub_services' => 'array',
        'preferred_time' => 'date',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'client_id'
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

    /**
     * Get the client information of the current service service request
     */
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id')->with('account', 'contact');
    }

    /**
     * Get all users assigned to the service request
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'service_request_assigned')->with('account', 'roles');
    }

    /**
     * Get the price of the current service
     */
    public function price()
    {
        return $this->belongsTo(Price::class, 'price_id', 'id');
    }

    /**
     * Get the service and sub service of the current service request
     */
    public function service()
    {
        return $this->hasOne(Service::class, 'id', 'service_id')->with('category')->withDefault();
    }

    // public function cses()
    // {
    //     return $this->belongsToMany(User::class, 'service_request_assigned')->with('account', 'roles', 'contact');
    // }

    /**
     * Get the invoice of the current service request
     */
    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }


    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function services()
    {
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
    public function payment_disbursed()
    {
        return $this->belongsTo(PaymentDisbursed::class);
    }

    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status_id');
    }

    public function service_request()
    {
        return $this->hasOne(ServiceRequest::class, 'uuid', 'service_request_id');
    }

    public function address()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    public function service_request_medias()
    {
        return $this->hasMany(serviceRequestMedia::class)->with('media_files');
    }

    // Wrong, this return just the first assigned person to a request
    // public function service_request_assignee()
    // {
    //     return $this->belongsTo(ServiceRequestAssigned::class, 'id', 'service_request_id');
    // }


    public function clientDiscount()
    {
        return $this->belongsTo(ClientDiscount::class, 'client_id');
    }

    public function clientDiscounts()
    {
        return $this->hasMany(ClientDiscount::class, 'client_id', 'client_id');
    }

    public function payment_status()
    {
        return $this->belongsTo(Payment::class, 'id', 'user_id');
    }

    // Wrong, this return just the first assigned person to a request
    // public function cse_service_request()
    // {
    //     return $this->belongsTo(ServiceRequestAssigned::class, 'service_request_id')->with('users', 'client');
    // }


    public function payment_statuses()
    {
        return $this->belongsTo(Payment::class, 'unique_id', 'unique_id');
    }


    public function service_request_cancellation()
    {
        return $this->belongsTo(ServiceRequestCancellation::class, 'id', 'service_request_id');
    }

    public function warranty()
    {
        return $this->hasOne(ServiceRequestWarranty::class, 'service_request_id');
    }

    public function bookingFee()
    {
        return $this->hasOne(Price::class, 'id', 'price_id');
    }

    /**
     * Get users assigned to a service request
     */
    public function service_request_assignees()
    {
        return $this->hasMany(ServiceRequestAssigned::class, 'service_request_id')->with('user');
    }

    public function service_request_warranty()
    {
        return $this->hasOne(ServiceRequestWarranty::class, 'service_request_id', 'id');
    }

    public function serviceRequestMedias()
    {
        return $this->belongsToMany(Media::class, 'service_request_medias');
    }

    public function serviceRequestProgresses()
    {
        return $this->hasMany(ServiceRequestProgress::class, 'service_request_id')->with('user', 'subStatus');
    }

    public function serviceRequestReports()
    {
        return $this->hasMany(ServiceRequestReport::class, 'service_request_id');
    }

    public function toolRequest()
    {
        return $this->hasOne(ToolRequest::class, 'service_request_id')->with('approver', 'requester')->latest('created_at');
    }

    public function rfqDispatchNotification()
    {
        return $this->hasOne(RfqDispatchNotification::class, 'service_request_id', 'id');
    }


    /**
     * Scope a query to only include all pending requests
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    //Scope to return all services
    public function scopePendingRequests($query)
    {
        return $query->select('*')
            ->where('status_id', 1);
    }
}
