<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\GenerateUniqueIdentity as Generator;

class ToolRequest extends Model
{
    use SoftDeletes, Generator;

    protected $fillable = [
        'unique_id', 'requested_by', 'approved_by', 'service_request_id', 'status', 'is_returned'
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new Tool Request is to be created
        static::creating(function ($toolRequest) {
            // Create a Unique Tool Request uuid id
            $toolRequest->uuid = (string) Str::uuid();
 
            // Create a Unique Tool Request Batch Number
            $toolRequest->unique_id = static::generate('tool_requests', 'TRF-');

        });

    }
}
