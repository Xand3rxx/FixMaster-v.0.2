<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use SoftDeletes;

    const USER_TYPES = ['cse', 'supplier', 'technician'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'form_data' => 'array',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new Status is to be created
        static::creating(function ($applicant) {
            $applicant->uuid = (string) \Illuminate\Support\Str::uuid();
        });
    }
}
