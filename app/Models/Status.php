<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Status extends Model
{

    protected $fillable = [
        'user_id', 'name', 'sub_status', 'ranking',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'sub_status' => 'array',
    ];

    const ONGOING_SUBSTATUSES = [
        '0' => 'Assigned CSE',
        '1' => 'Assigned QA',
        '2' => 'Assigned Technician',
        '3' => 'Contacted Client for availabilty',
        '4' => 'En-route to Client\'s address',
        '5' => 'Arrived',
        '6' => 'Perfoming diagnosis',
        '7' => 'Completed diagnosis',
        '8' => 'Issued RFQ',
        '9' =>  'Awaiting supplier\'s feedback',
        '10' => 'RFQ Delivery: Pending',
        '11' => 'RFQ Delivery: Shipped',
        '12' => 'RFQ Delivered',
        '13' => 'Job Completed'
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
        // Create a uuid when a new Status is to be created
        static::creating(function ($status) {
            $status->uuid = (string) Str::uuid();
        });
    }
}
